<?php

namespace Database\Seeders;

use App\Models\WaAdminFollowup;
use App\Models\WaAnalyticsEvent;
use App\Models\WaContact;
use App\Models\WaConversation;
use App\Models\WaMessage;
use App\Support\HotlineState;
use Illuminate\Database\Seeder;

class HotlineDummySeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'phone_number' => '628111111111',
                'wa_name' => 'Budi',
                'name' => 'Budi Santoso',
                'semester' => '4',
                'campus' => 'UNPAS',
                'major' => 'Informatika',
                'referral_code' => 'REF-A01',
                'group_type' => 'A',
                'chat_state' => HotlineState::WAITING_ADMIN,
                'status' => 'pending',
                'source' => 'hero',
                'campaign' => 'main_cta',
            ],
            [
                'phone_number' => '628122222222',
                'wa_name' => 'Rina',
                'name' => 'Rina Maharani',
                'semester' => '2',
                'campus' => 'ITENAS',
                'major' => 'Arsitektur',
                'referral_code' => null,
                'group_type' => 'B',
                'chat_state' => HotlineState::WAITING_ADMIN,
                'status' => 'in_progress',
                'source' => 'navbar',
                'campaign' => 'header',
            ],
            [
                'phone_number' => '628133333333',
                'wa_name' => 'Andi',
                'name' => 'Andi Saputra',
                'semester' => '6',
                'campus' => 'UNPAD',
                'major' => 'Hukum',
                'referral_code' => 'REF-CAMPUS',
                'group_type' => 'A',
                'chat_state' => HotlineState::WAITING_ADMIN,
                'status' => 'done',
                'source' => 'landing_page',
                'campaign' => 'default',
            ],
        ];

        foreach ($samples as $index => $sample) {
            $contact = WaContact::updateOrCreate(
                ['phone_number' => $sample['phone_number']],
                [
                    'wa_name' => $sample['wa_name'],
                    'name' => $sample['name'],
                    'semester' => $sample['semester'],
                    'campus' => $sample['campus'],
                    'major' => $sample['major'],
                    'referral_code' => $sample['referral_code'],
                    'group_type' => $sample['group_type'],
                    'chat_state' => $sample['chat_state'],
                    'source' => $sample['source'],
                    'click_token' => 'CTA-SEED00'.($index + 1),
                    'first_clicked_at' => now()->subDays(4 - $index),
                    'first_chatted_at' => now()->subDays(4 - $index)->addMinutes(5),
                    'last_message_at' => now()->subDays(4 - $index)->addMinutes(25),
                    'biodata_completed_at' => now()->subDays(4 - $index)->addMinutes(12),
                    'waiting_admin_at' => now()->subDays(4 - $index)->addMinutes(15),
                    'metadata' => ['campaign' => $sample['campaign']],
                ]
            );

            $conversation = WaConversation::updateOrCreate(
                ['contact_id' => $contact->id],
                [
                    'started_at' => $contact->first_chatted_at,
                    'status' => 'open',
                    'source' => 'whatsapp',
                    'group_type' => $sample['group_type'],
                    'campaign' => $sample['campaign'],
                ]
            );

            WaAnalyticsEvent::updateOrCreate(
                ['reference' => $contact->click_token, 'event_type' => 'cta_clicked'],
                [
                    'contact_id' => $contact->id,
                    'conversation_id' => $conversation->id,
                    'source' => $sample['source'],
                    'campaign' => $sample['campaign'],
                    'phone_number' => $contact->phone_number,
                    'payload' => ['seeded' => true],
                    'occurred_at' => $contact->first_clicked_at,
                ]
            );

            foreach ([
                ['incoming_message', 'Halo admin'],
                ['biodata_completed', 'Biodata lengkap'],
                ['referral_submitted', $sample['referral_code'] ?: 'tidak ada'],
            ] as $messageIndex => [$eventType, $messageBody]) {
                WaMessage::updateOrCreate(
                    ['message_id' => 'seed-'.$contact->id.'-'.$messageIndex],
                    [
                        'contact_id' => $contact->id,
                        'conversation_id' => $conversation->id,
                        'direction' => $messageIndex === 0 ? 'inbound' : 'outbound',
                        'message_type' => 'text',
                        'body' => $messageBody,
                        'payload' => ['seeded' => true],
                        'sent_at' => $contact->first_chatted_at?->copy()->addMinutes($messageIndex * 3),
                    ]
                );

                WaAnalyticsEvent::updateOrCreate(
                    ['reference' => 'seed-event-'.$contact->id.'-'.$messageIndex, 'event_type' => $eventType],
                    [
                        'contact_id' => $contact->id,
                        'conversation_id' => $conversation->id,
                        'source' => 'whatsapp',
                        'campaign' => $sample['campaign'],
                        'phone_number' => $contact->phone_number,
                        'payload' => ['seeded' => true, 'body' => $messageBody],
                        'occurred_at' => $contact->first_chatted_at?->copy()->addMinutes($messageIndex * 4),
                    ]
                );
            }

            WaAdminFollowup::updateOrCreate(
                ['contact_id' => $contact->id],
                [
                    'admin_name' => 'Seeder Admin',
                    'status' => $sample['status'],
                    'notes' => 'Dummy follow-up data for dashboard preview.',
                    'followed_up_at' => $sample['status'] === 'done' ? now()->subDay() : null,
                ]
            );
        }
    }
}
