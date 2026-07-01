<?php

namespace App\Http\Controllers;

use App\Services\HotlineBotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhatsAppWebhookController extends Controller
{
    public function __construct(private readonly HotlineBotService $bot)
    {
    }

    public function verify(Request $request): Response
    {
        $mode = $request->query('hub_mode') ?? $request->query('hub.mode');
        $token = $request->query('hub_verify_token') ?? $request->query('hub.verify_token');
        $challenge = $request->query('hub_challenge') ?? $request->query('hub.challenge');

        if ($mode === 'subscribe' && $token === config('hotline.webhook_verify_token')) {
            return response((string) $challenge, 200);
        }

        return response('Invalid verify token.', 403);
    }

    public function handle(Request $request): JsonResponse
    {
        $this->bot->processIncoming($request->all());

        return response()->json(['status' => 'ok']);
    }
}
