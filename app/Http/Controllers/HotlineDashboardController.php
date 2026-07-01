<?php

namespace App\Http\Controllers;

use App\Models\WaAdminFollowup;
use App\Models\WaAnalyticsEvent;
use App\Models\WaContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotlineDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $group = $request->query('group');
        $campus = $request->query('campus');
        $status = $request->query('status');

        $contacts = WaContact::query()
            ->with(['followUps' => fn ($query) => $query->latest('id')])
            ->when(filled($group), fn ($query) => $query->where('group_type', $group))
            ->when(filled($campus), fn ($query) => $query->where('campus', $campus))
            ->when(filled($status), function ($query) use ($status) {
                $query->whereHas('followUps', fn ($followUp) => $followUp->where('status', $status));
            })
            ->latest('last_message_at')
            ->paginate(15)
            ->withQueryString();

        $summary = [
            'cta_clicked' => WaAnalyticsEvent::where('event_type', 'cta_clicked')->count(),
            'chatted' => WaAnalyticsEvent::where('event_type', 'incoming_message')->select('phone_number')->distinct()->count('phone_number'),
            'biodata_completed' => WaAnalyticsEvent::where('event_type', 'biodata_completed')->count(),
            'group_a' => WaContact::where('group_type', 'A')->count(),
            'group_b' => WaContact::where('group_type', 'B')->count(),
            'waiting_admin' => WaContact::where('chat_state', 'waiting_admin')->count(),
        ];

        $campusBreakdown = WaContact::query()
            ->selectRaw('campus, count(*) as total')
            ->whereNotNull('campus')
            ->groupBy('campus')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $latestEvents = WaAnalyticsEvent::query()
            ->latest('occurred_at')
            ->limit(10)
            ->get();

        return view('hotline.dashboard', compact('contacts', 'summary', 'campusBreakdown', 'latestEvents', 'group', 'campus', 'status'));
    }

    public function show(WaContact $contact): View
    {
        $contact->load([
            'messages' => fn ($query) => $query->latest('id')->limit(30),
            'followUps' => fn ($query) => $query->latest('id'),
            'analyticsEvents' => fn ($query) => $query->latest('occurred_at')->limit(20),
        ]);

        return view('hotline.show', compact('contact'));
    }

    public function updateFollowUp(Request $request, WaContact $contact): RedirectResponse
    {
        $data = $request->validate([
            'admin_name' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:pending,in_progress,done'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['followed_up_at'] = $data['status'] === 'done' ? now() : null;

        WaAdminFollowup::create([
            'contact_id' => $contact->id,
            ...$data,
        ]);

        return back();
    }
}
