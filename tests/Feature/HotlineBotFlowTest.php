<?php

namespace Tests\Feature;

use App\Models\WaContact;
use App\Services\HotlineBotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotlineBotFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_moves_contact_to_waiting_admin_after_biodata_and_referral_flow(): void
    {
        config()->set('hotline.bot_enabled', true);

        $service = app(HotlineBotService::class);

        $service->processIncoming($this->payloadFor('628111111111', 'Halo admin'));
        $service->processIncoming($this->payloadFor('628111111111', "Nama: Budi\nSemester: 4\nKampus: Unpas\nJurusan: Informatika"));
        $service->processIncoming($this->payloadFor('628111111111', 'REF-ABC'));

        $contact = WaContact::firstOrFail();

        $this->assertSame('Budi', $contact->name);
        $this->assertSame('4', $contact->semester);
        $this->assertSame('Unpas', $contact->campus);
        $this->assertSame('Informatika', $contact->major);
        $this->assertSame('REF-ABC', $contact->referral_code);
        $this->assertSame('A', $contact->group_type);
        $this->assertSame('waiting_admin', $contact->chat_state);
    }

    public function test_it_falls_back_to_guided_questions_when_biodata_is_incomplete(): void
    {
        config()->set('hotline.bot_enabled', true);

        $service = app(HotlineBotService::class);

        $service->processIncoming($this->payloadFor('628222222222', 'Halo'));
        $service->processIncoming($this->payloadFor('628222222222', 'Saya Rina semester 2'));

        $contact = WaContact::firstOrFail();

        $this->assertSame('awaiting_campus', $contact->chat_state);
        $this->assertSame('2', $contact->semester);
        $this->assertSame('Rina', $contact->name);
    }

    private function payloadFor(string $phone, string $body): array
    {
        return [
            'entry' => [[
                'changes' => [[
                    'value' => [
                        'contacts' => [[
                            'wa_id' => $phone,
                            'profile' => ['name' => 'Test User'],
                        ]],
                        'messages' => [[
                            'from' => $phone,
                            'id' => 'wamid.'.md5($body),
                            'type' => 'text',
                            'text' => ['body' => $body],
                        ]],
                    ],
                ]],
            ]],
        ];
    }
}
