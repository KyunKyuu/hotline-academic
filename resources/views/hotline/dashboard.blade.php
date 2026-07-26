@extends('layouts.app')

@section('content')
<div class="stack">
    <div>
        <span class="badge">Dashboard Hotline</span>
        <h1 class="h1-display">Analytics &amp; Antrean Admin</h1>
        <p class="muted">Pantau aktivitas lead masuk WhatsApp, A/B referral group, dan status follow-up mahasiswa.</p>
    </div>

    <div class="grid grid-3">
        <div class="card metric"><span class="muted">CTA Clicked</span><strong>{{ $summary['cta_clicked'] }}</strong></div>
        <div class="card metric"><span class="muted">User Sudah Chat</span><strong>{{ $summary['chatted'] }}</strong></div>
        <div class="card metric"><span class="muted">Biodata Lengkap</span><strong>{{ $summary['biodata_completed'] }}</strong></div>
        <div class="card metric"><span class="muted">Group A</span><strong>{{ $summary['group_a'] }}</strong></div>
        <div class="card metric"><span class="muted">Group B</span><strong>{{ $summary['group_b'] }}</strong></div>
        <div class="card metric"><span class="muted">Waiting Admin</span><strong>{{ $summary['waiting_admin'] }}</strong></div>
    </div>

    <div class="grid grid-2">
        <div class="card section">
            <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Filter Kontak</h3>
            <form method="get" class="filters">
                <div style="flex:1 1 180px; display:flex; flex-direction:column; gap:6px;">
                    <label>Group</label>
                    <select name="group">
                        <option value="">Semua</option>
                        <option value="A" @selected($group === 'A')>Group A</option>
                        <option value="B" @selected($group === 'B')>Group B</option>
                    </select>
                </div>
                <div style="flex:1 1 220px; display:flex; flex-direction:column; gap:6px;">
                    <label>Kampus</label>
                    <input type="text" name="campus" value="{{ $campus }}" placeholder="Contoh: Universitas Indonesia">
                </div>
                <div style="flex:1 1 220px; display:flex; flex-direction:column; gap:6px;">
                    <label>Status Follow Up</label>
                    <select name="status">
                        <option value="">Semua</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="in_progress" @selected($status === 'in_progress')>In Progress</option>
                        <option value="done" @selected($status === 'done')>Done</option>
                    </select>
                </div>
                <div style="display:flex; align-items:end;">
                    <button type="submit" class="button button-primary" style="width:100%;">Filter</button>
                </div>
            </form>
        </div>

        <div class="card section">
            <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Top Kampus</h3>
            <div class="stack" style="gap:12px;">
                @forelse($campusBreakdown as $item)
                    <div style="display:flex; justify-content:space-between; gap:16px; font-size:14px; border-bottom: 1px solid var(--hairline); padding-bottom:8px;">
                        <span>{{ $item->campus }}</span>
                        <strong>{{ $item->total }}</strong>
                    </div>
                @empty
                    <p class="muted" style="font-size:14px;">Belum ada data kampus.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card section">
        <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Kontak Hotline</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Nomor WA</th>
                    <th>Kampus</th>
                    <th>Group</th>
                    <th>State Chat</th>
                    <th>Status Follow Up</th>
                    <th style="text-align:right;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td><strong>{{ $contact->name ?: $contact->wa_name ?: '-' }}</strong></td>
                        <td>{{ $contact->phone_number }}</td>
                        <td>{{ $contact->campus ?: '-' }}</td>
                        <td>
                            @if($contact->group_type)
                                <span class="pill">Group {{ $contact->group_type }}</span>
                            @else
                                <span class="muted">-</span>
                            @endif
                        </td>
                        <td><code>{{ $contact->chat_state }}</code></td>
                        <td>
                            @php
                                $fuStatus = optional($contact->followUps->first())->status ?: 'pending';
                            @endphp
                            <span class="pill" style="{{ $fuStatus === 'done' ? 'background:#d8ecd9; color:#125d38;' : ($fuStatus === 'in_progress' ? 'background:#fff3cd; color:#856404;' : '') }}">
                                {{ $fuStatus }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('hotline.contacts.show', $contact) }}" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px;">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="muted" style="text-align: center; padding: 24px 0;">Belum ada kontak yang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $contacts->links() }}
        </div>
    </div>

    <div class="card section">
        <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Event Terakhir</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Jenis Event</th>
                    <th>Nomor</th>
                    <th>Source</th>
                    <th>Referensi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestEvents as $event)
                    <tr>
                        <td>{{ $event->occurred_at?->format('d M Y H:i') }}</td>
                        <td><code>{{ $event->event_type }}</code></td>
                        <td>{{ $event->phone_number ?: '-' }}</td>
                        <td>{{ $event->source ?: '-' }}</td>
                        <td class="muted">{{ $event->reference ?: '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="muted" style="text-align: center; padding: 24px 0;">Belum ada log event aktivitas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
