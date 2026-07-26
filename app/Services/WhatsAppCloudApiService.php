<?php

namespace App\Services;

use App\Models\WaAnalyticsEvent;
use App\Models\WaContact;
use App\Models\WaConversation;
use App\Models\WaMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WhatsAppCloudApiService
{
    public function sendText(WaContact $contact, ?WaConversation $conversation, string $message): void
    {
        $message = str_replace('\n', PHP_EOL, $message);

        $payload = [
            'target' => $contact->phone_number,
            'message' => $message,
        ];

        $messageId = null;

        if ($this->isConfigured()) {
            $response = Http::withHeaders([
                'Authorization' => (string) config('hotline.access_token'),
            ])->asForm()->post($this->endpoint(), $payload);

            if ($response->failed()) {
                Log::warning('Fonnte API send failed.', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                    'phone' => $contact->phone_number,
                ]);
            } else {
                $responseJson = $response->json();
                $idData = data_get($responseJson, 'id');
                if (is_array($idData)) {
                    $messageId = $idData[0] ?? null;
                } else {
                    $messageId = $idData;
                }
            }
        } else {
            Log::info('Fonnte API not configured. Outbound message stored locally only.', [
                'phone' => $contact->phone_number,
                'body' => $message,
            ]);
        }

        $storedMessage = WaMessage::create([
            'contact_id' => $contact->id,
            'conversation_id' => $conversation?->id,
            'direction' => 'outbound',
            'message_id' => $messageId ?: 'local-'.Str::uuid(),
            'message_type' => 'text',
            'body' => $message,
            'payload' => $payload,
            'sent_at' => now(),
        ]);

        WaAnalyticsEvent::create([
            'contact_id' => $contact->id,
            'conversation_id' => $conversation?->id,
            'event_type' => 'outbound_message',
            'phone_number' => $contact->phone_number,
            'reference' => $storedMessage->message_id,
            'payload' => ['body' => $message],
            'occurred_at' => now(),
        ]);
    }

    public function isConfigured(): bool
    {
        return filled(config('hotline.access_token'));
    }

    private function endpoint(): string
    {
        return 'https://api.fonnte.com/send';
    }
}
