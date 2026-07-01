<?php

namespace App\Services;

use App\Models\WaAdminFollowup;
use App\Models\WaAnalyticsEvent;
use App\Models\WaContact;
use App\Models\WaConversation;
use App\Models\WaMessage;
use App\Support\HotlineState;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class HotlineBotService
{
    public function __construct(
        private readonly BiodataParserService $parser,
        private readonly WhatsAppCloudApiService $whatsApp
    ) {
    }

    public function processIncoming(array $payload): void
    {
        foreach (data_get($payload, 'entry', []) as $entry) {
            foreach (data_get($entry, 'changes', []) as $change) {
                foreach (data_get($change, 'value.messages', []) as $message) {
                    if (($message['type'] ?? 'text') !== 'text') {
                        continue;
                    }

                    $phone = $this->normalizePhone((string) ($message['from'] ?? ''));

                    if ($phone === '') {
                        continue;
                    }

                    $matchedContact = collect(data_get($change, 'value.contacts', []))
                        ->firstWhere('wa_id', $message['from'] ?? null);
                    $profileName = data_get($matchedContact, 'profile.name');

                    $contact = WaContact::firstOrCreate(
                        ['phone_number' => $phone],
                        [
                            'wa_name' => $profileName,
                            'chat_state' => HotlineState::NEW,
                            'first_chatted_at' => now(),
                            'source' => 'whatsapp',
                        ]
                    );

                    $body = trim((string) data_get($message, 'text.body', ''));
                    $clickReference = $this->extractClickReference($body);

                    $contact->forceFill([
                        'wa_name' => $profileName ?: $contact->wa_name,
                        'first_chatted_at' => $contact->first_chatted_at ?: now(),
                        'last_message_at' => now(),
                    ])->save();

                    if ($clickReference && blank($contact->click_token)) {
                        $ctaEvent = WaAnalyticsEvent::query()
                            ->where('event_type', 'cta_clicked')
                            ->where('reference', $clickReference)
                            ->latest('occurred_at')
                            ->first();

                        $contact->forceFill([
                            'click_token' => $clickReference,
                            'first_clicked_at' => $ctaEvent?->occurred_at,
                            'source' => $ctaEvent?->source ?: $contact->source,
                            'metadata' => array_filter([
                                ...($contact->metadata ?? []),
                                'campaign' => $ctaEvent?->campaign,
                            ]),
                        ])->save();
                    }

                    $conversation = $this->resolveConversation($contact);

                    $storedMessage = WaMessage::create([
                        'contact_id' => $contact->id,
                        'conversation_id' => $conversation->id,
                        'direction' => 'inbound',
                        'message_id' => $message['id'] ?? 'wamid-local',
                        'message_type' => 'text',
                        'body' => $body,
                        'payload' => $message,
                        'sent_at' => now(),
                    ]);

                    if (config('hotline.track_incoming_messages')) {
                        WaAnalyticsEvent::create([
                            'contact_id' => $contact->id,
                            'conversation_id' => $conversation->id,
                            'event_type' => 'incoming_message',
                            'source' => 'whatsapp',
                            'phone_number' => $contact->phone_number,
                            'reference' => $storedMessage->message_id,
                            'payload' => $message,
                            'occurred_at' => now(),
                        ]);
                    }

                    if (! config('hotline.bot_enabled')) {
                        continue;
                    }

                    $this->advanceFlow($contact->fresh(), $conversation, $body);
                }
            }
        }
    }

    private function advanceFlow(WaContact $contact, WaConversation $conversation, string $messageBody): void
    {
        $state = $contact->chat_state ?: HotlineState::NEW;

        if ($state === HotlineState::NEW) {
            $contact->update(['chat_state' => HotlineState::AWAITING_BIODATA]);
            $this->whatsApp->sendText($contact, $conversation, (string) config('hotline.welcome_message'));
            return;
        }

        if ($state === HotlineState::AWAITING_BIODATA) {
            $parsed = $this->parser->parse($messageBody);
            $contact->fill(Arr::only($parsed['data'], ['name', 'semester', 'campus', 'major']));

            if ($parsed['success']) {
                $contact->forceFill([
                    'chat_state' => HotlineState::AWAITING_REFERRAL,
                    'biodata_completed_at' => now(),
                ])->save();

                WaAnalyticsEvent::create([
                    'contact_id' => $contact->id,
                    'conversation_id' => $conversation->id,
                    'event_type' => 'biodata_completed',
                    'source' => 'whatsapp',
                    'phone_number' => $contact->phone_number,
                    'payload' => $parsed['data'],
                    'occurred_at' => now(),
                ]);

                $this->whatsApp->sendText($contact, $conversation, (string) config('hotline.referral_prompt'));
                return;
            }

            $contact->save();

            if (config('hotline.guided_fallback')) {
                $nextState = $this->parser->nextStateFromMissing($parsed['missing']);
                $contact->update(['chat_state' => $nextState]);
                $this->whatsApp->sendText($contact, $conversation, $this->parser->questionForState($nextState));
                return;
            }

            $this->whatsApp->sendText($contact, $conversation, "Format biodata belum terbaca.\n\nSilakan kirim ulang dengan format:\nNama:\nSemester:\nKampus:\nJurusan:");
            return;
        }

        if (in_array($state, HotlineState::guidedStates(), true)) {
            $fieldMap = [
                HotlineState::AWAITING_NAME => 'name',
                HotlineState::AWAITING_SEMESTER => 'semester',
                HotlineState::AWAITING_CAMPUS => 'campus',
                HotlineState::AWAITING_MAJOR => 'major',
            ];

            $field = $fieldMap[$state];
            $normalized = $this->parser->normalizeSingleField($state, $messageBody);

            if (blank($normalized)) {
                $this->whatsApp->sendText($contact, $conversation, $this->parser->questionForState($state));
                return;
            }

            $contact->{$field} = $normalized;

            $missing = collect(['name', 'semester', 'campus', 'major'])
                ->filter(fn (string $candidate) => blank($contact->{$candidate}))
                ->values()
                ->all();

            if ($missing === []) {
                $contact->forceFill([
                    'chat_state' => HotlineState::AWAITING_REFERRAL,
                    'biodata_completed_at' => $contact->biodata_completed_at ?: now(),
                ])->save();

                WaAnalyticsEvent::create([
                    'contact_id' => $contact->id,
                    'conversation_id' => $conversation->id,
                    'event_type' => 'biodata_completed',
                    'source' => 'whatsapp',
                    'phone_number' => $contact->phone_number,
                    'payload' => $contact->only(['name', 'semester', 'campus', 'major']),
                    'occurred_at' => now(),
                ]);

                $this->whatsApp->sendText($contact, $conversation, (string) config('hotline.referral_prompt'));
                return;
            }

            $nextState = $this->parser->nextStateFromMissing($missing);
            $contact->update(['chat_state' => $nextState]);
            $this->whatsApp->sendText($contact, $conversation, $this->parser->questionForState($nextState));
            return;
        }

        if ($state === HotlineState::AWAITING_REFERRAL) {
            $referralCode = $this->normalizeReferral($messageBody);
            $groupType = $referralCode ? 'A' : 'B';

            $contact->forceFill([
                'referral_code' => $referralCode,
                'group_type' => $groupType,
                'chat_state' => HotlineState::WAITING_ADMIN,
                'waiting_admin_at' => now(),
            ])->save();

            $conversation->update(['group_type' => $groupType]);

            WaAdminFollowup::firstOrCreate(
                ['contact_id' => $contact->id, 'status' => 'pending'],
                ['notes' => 'Auto-created after chatbot handover.']
            );

            WaAnalyticsEvent::create([
                'contact_id' => $contact->id,
                'conversation_id' => $conversation->id,
                'event_type' => 'referral_submitted',
                'source' => 'whatsapp',
                'phone_number' => $contact->phone_number,
                'payload' => [
                    'referral_code' => $referralCode,
                    'group_type' => $groupType,
                ],
                'occurred_at' => now(),
            ]);

            $this->whatsApp->sendText($contact, $conversation, (string) config('hotline.completion_message'));
            return;
        }

        if ($state === HotlineState::WAITING_ADMIN) {
            $this->whatsApp->sendText($contact, $conversation, 'Data Anda sudah masuk ke admin. Tim kami akan menghubungi Anda secepatnya.');
        }
    }

    private function resolveConversation(WaContact $contact): WaConversation
    {
        return $contact->conversations()
            ->whereNull('ended_at')
            ->latest('id')
            ->first() ?? $contact->conversations()->create([
                'started_at' => now(),
                'status' => 'open',
                'source' => $contact->source ?: 'whatsapp',
                'group_type' => $contact->group_type,
                'campaign' => data_get($contact->metadata, 'campaign'),
            ]);
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?: '';

        if (Str::startsWith($digits, '0')) {
            $digits = config('hotline.default_country_code').substr($digits, 1);
        }

        return $digits;
    }

    private function normalizeReferral(string $value): ?string
    {
        $trimmed = Str::of($value)->lower()->trim()->value();

        if ($trimmed === '' || in_array($trimmed, ['-', 'tidak ada', 'ga ada', 'gak ada', 'skip', 'no', 'none'], true)) {
            return null;
        }

        return Str::upper(trim((string) Str::of($value)->replace(' ', '')->value()));
    }

    private function extractClickReference(string $body): ?string
    {
        if (preg_match('/\b(CTA-[A-Z0-9]{8})\b/', Str::upper($body), $matches)) {
            return $matches[1];
        }

        return null;
    }
}
