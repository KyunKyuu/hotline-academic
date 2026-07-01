@extends('layouts.app')

@section('content')
    <section style="padding:12px 0 48px;">
        <div class="container stack">
            <div style="display:flex;justify-content:space-between;gap:16px;align-items:center;">
                <div>
                    <span class="badge">Detail Kontak</span>
                    <h1 style="margin:12px 0 0;">{{ $contact->name ?: $contact->wa_name ?: $contact->phone_number }}</h1>
                </div>
                <a class="button button-secondary" href="{{ route('hotline.dashboard') }}">Kembali</a>
            </div>

            <div class="grid grid-2">
                <div class="card section detail-list">
                    <div><strong>Nomor</strong><br>{{ $contact->phone_number }}</div>
                    <div><strong>Semester</strong><br>{{ $contact->semester ?: '-' }}</div>
                    <div><strong>Kampus</strong><br>{{ $contact->campus ?: '-' }}</div>
                    <div><strong>Jurusan</strong><br>{{ $contact->major ?: '-' }}</div>
                    <div><strong>Referral</strong><br>{{ $contact->referral_code ?: '-' }}</div>
                    <div><strong>Group</strong><br>{{ $contact->group_type ?: '-' }}</div>
                    <div><strong>State</strong><br>{{ $contact->chat_state }}</div>
                </div>

                <div class="card section">
                    <h3 style="margin-top:0;">Update Follow Up</h3>
                    <form method="post" action="{{ route('hotline.contacts.follow-up', $contact) }}" class="stack">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="mini">Nama Admin</label>
                            <input type="text" name="admin_name" placeholder="Contoh: Rina">
                        </div>
                        <div>
                            <label class="mini">Status</label>
                            <select name="status">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <div>
                            <label class="mini">Catatan</label>
                            <textarea name="notes" rows="4" placeholder="Catatan follow up admin"></textarea>
                        </div>
                        <button class="button button-primary" type="submit">Simpan Follow Up</button>
                    </form>
                </div>
            </div>

            <div class="card section">
                <h3 style="margin-top:0;">Riwayat Chat</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Arah</th>
                            <th>Pesan</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contact->messages as $message)
                            <tr>
                                <td>{{ $message->direction }}</td>
                                <td>{{ $message->body }}</td>
                                <td>{{ $message->sent_at?->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="muted">Belum ada pesan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card section">
                <h3 style="margin-top:0;">Riwayat Event</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Reference</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contact->analyticsEvents as $event)
                            <tr>
                                <td>{{ $event->event_type }}</td>
                                <td>{{ $event->reference ?: '-' }}</td>
                                <td>{{ $event->occurred_at?->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="muted">Belum ada event.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
