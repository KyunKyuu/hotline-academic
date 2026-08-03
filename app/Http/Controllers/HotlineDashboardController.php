<?php

namespace App\Http\Controllers;

use App\Models\WaAdminFollowup;
use App\Models\WaAnalyticsEvent;
use App\Models\WaContact;
use App\Models\ReferralCode;
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
        $referralCode = $request->query('referral_code');
        $segment = $request->query('segment', 'all');

        $contactsQuery = WaContact::query()
            ->with(['followUps' => fn ($query) => $query->latest('id'), 'referralCode'])
            ->when(filled($group), fn ($query) => $query->where('group_type', $group))
            ->when(filled($campus), fn ($query) => $query->where('campus', 'like', '%' . $campus . '%'))
            ->when(filled($referralCode), fn ($query) => $query->where('referral_code', $referralCode))
            ->when(filled($status), function ($query) use ($status) {
                $query->whereHas('followUps', fn ($followUp) => $followUp->where('status', $status));
            });

        // Apply segment filters
        if ($segment === 'pending') {
            $contactsQuery->where(function ($query) {
                $query->whereHas('followUps', fn ($fu) => $fu->where('status', 'pending'))
                      ->orWhereDoesntHave('followUps')
                      ->orWhere('chat_state', 'waiting_admin');
            });
        } elseif ($segment === 'in_progress') {
            $contactsQuery->whereHas('followUps', fn ($fu) => $fu->where('status', 'in_progress'));
        } elseif ($segment === 'done') {
            $contactsQuery->whereHas('followUps', fn ($fu) => $fu->where('status', 'done'));
        } elseif ($segment === 'group_a') {
            $contactsQuery->where('group_type', 'A');
        } elseif ($segment === 'group_b') {
            $contactsQuery->where('group_type', 'B');
        }

        $contacts = $contactsQuery->latest('last_message_at')
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
            ->get();

        $referralCodesList = ReferralCode::orderBy('code')->get();
        $referralBreakdown = ReferralCode::orderByDesc('usage_count')->get();

        return view('hotline.dashboard', compact(
            'contacts', 'summary', 'campusBreakdown', 'group', 'campus', 'status', 'segment',
            'referralCode', 'referralCodesList', 'referralBreakdown'
        ));
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

    // --- REFERRAL CODES CRUD ---

    public function referralsIndex(): View
    {
        $referrals = ReferralCode::orderBy('code')->paginate(15);
        return view('admin.hotline.referrals.index', compact('referrals'));
    }

    public function referralsCreate(): View
    {
        return view('admin.hotline.referrals.form', [
            'referral' => new ReferralCode(),
        ]);
    }

    public function referralsStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:referral_codes,code'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $data['code'] = strtoupper(str_replace(' ', '', $data['code']));

        // Double check uniqueness after normalization
        if (ReferralCode::where('code', $data['code'])->exists()) {
            return back()->withErrors(['code' => 'Kode referral tersebut sudah digunakan.'])->withInput();
        }

        ReferralCode::create($data);

        return redirect()->route('admin.hotline.referrals.index')->with('status', 'Kode Referral berhasil ditambahkan.');
    }

    public function referralsEdit(ReferralCode $referral): View
    {
        return view('admin.hotline.referrals.form', compact('referral'));
    }

    public function referralsUpdate(Request $request, ReferralCode $referral): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:referral_codes,code,' . $referral->id],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $data['code'] = strtoupper(str_replace(' ', '', $data['code']));

        // Double check uniqueness after normalization
        if (ReferralCode::where('code', $data['code'])->where('id', '!=', $referral->id)->exists()) {
            return back()->withErrors(['code' => 'Kode referral tersebut sudah digunakan.'])->withInput();
        }

        $referral->update($data);

        return redirect()->route('admin.hotline.referrals.index')->with('status', 'Kode Referral berhasil diperbarui.');
    }

    public function referralsDestroy(ReferralCode $referral): RedirectResponse
    {
        $referral->delete();

        return redirect()->route('admin.hotline.referrals.index')->with('status', 'Kode Referral berhasil dihapus.');
    }
}
