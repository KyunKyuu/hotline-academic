<?php

namespace App\Http\Controllers;

use App\Models\WaAnalyticsEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function index(): View
    {
        return view('landing.index', [
            'businessPhone' => config('hotline.business_phone'),
        ]);
    }

    public function redirectToWhatsApp(Request $request): RedirectResponse
    {
        $source = $request->string('source', 'landing_page')->value();
        $campaign = $request->string('campaign', 'default')->value();
        $clickToken = 'CTA-'.Str::upper(Str::random(8));
        $message = trim(config('hotline.prefilled_message').' Ref: '.$clickToken);

        if (config('hotline.track_cta')) {
            WaAnalyticsEvent::create([
                'event_type' => 'cta_clicked',
                'source' => $source,
                'campaign' => $campaign,
                'reference' => $clickToken,
                'payload' => [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'query' => $request->query(),
                ],
                'occurred_at' => now(),
            ]);
        }

        $phone = preg_replace('/\D+/', '', (string) config('hotline.business_phone'));

        if ($phone === '') {
            return redirect()->route('landing.index');
        }

        return redirect()->away('https://wa.me/'.$phone.'?text='.urlencode($message));
    }
}
