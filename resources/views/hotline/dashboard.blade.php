@extends('layouts.app')

@section('content')
    <section style="padding: 12px 0 48px;">
        <div class="container stack">
            <div>
                <span class="badge">Dashboard Hotline</span>
                <h1 style="margin:12px 0 0;">Analytics chatbot dan antrean admin WhatsApp.</h1>
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
                    <h3 style="margin-top:0;">Filter Kontak</h3>
                    <form method="get" class="filters">
                        <div style="flex:1 1 180px;">
                            <label class="mini">Group</label>
                            <select name="group">
                                <option value="">Semua</option>
                                <option value="A" @selected($group === 'A')>Group A</option>
                                <option value="B" @selected($group === 'B')>Group B</option>
                            </select>
                        </div>
                        <div style="flex:1 1 220px;">
                            <label class="mini">Kampus</label>
                            <input type="text" name="campus" value="{{ $campus }}" placeholder="Contoh: UNPAS">
                        </div>
                        <div style="flex:1 1 220px;">
                            <label class="mini">Status Follow Up</label>
                            <select name="status">
                                <option value="">Semua</option>
                                <option value="pending" @selected($status === 'pending')>Pending</option>
                                <option value="in_progress" @selected($status === 'in_progress')>In Progress</option>
                                <option value="done" @selected($status === 'done')>Done</option>
                            </select>
                        </div>
                        <div style="display:flex;align-items:end;">
                            <button type="submit" class="button button-primary">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="card section">
                    <h3 style="margin-top:0;">Top Kampus</h3>
                    <div class="stack">
                        @forelse($campusBreakdown as $item)
                            <div style="display:flex;justify-content:space-between;gap:16px;">
                                <span>{{ $item->campus }}</span>
                                <strong>{{ $item->total }}</strong>
                            </div>
                        @empty
                            <p class="muted">Belum ada data kampus.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card section">
                <h3 style="margin-top:0;">Kontak Hotline</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nomor</th>
                            <th>Kampus</th>
                            <th>Group</th>
                            <th>State</th>
                            <th>Follow Up</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr>
                                <td>{{ $contact->name ?: $contact->wa_name ?: '-' }}</td>
                                <td>{{ $contact->phone_number }}</td>
                                <td>{{ $contact->campus ?: '-' }}</td>
                                <td><span class="pill">{{ $contact->group_type ?: '-' }}</span></td>
                                <td>{{ $contact->chat_state }}</td>
                                <td>{{ optional($contact->followUps->first())->status ?: 'pending' }}</td>
                                <td><a href="{{ route('hotline.contacts.show', $contact) }}">Detail</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="muted">Belum ada kontak yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div style="margin-top:18px;">
                    {{ $contacts->links() }}
                </div>
            </div>

            <div class="card section">
                <h3 style="margin-top:0;">Event Terakhir</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Event</th>
                            <th>Nomor</th>
                            <th>Source</th>
                            <th>Reference</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestEvents as $event)
                            <tr>
                                <td>{{ $event->occurred_at?->format('d M Y H:i') }}</td>
                                <td>{{ $event->event_type }}</td>
                                <td>{{ $event->phone_number ?: '-' }}</td>
                                <td>{{ $event->source ?: '-' }}</td>
                                <td>{{ $event->reference ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="muted">Belum ada event.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
