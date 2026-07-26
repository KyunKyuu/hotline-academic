@extends('layouts.app')

@section('content')
<div class="stack">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px;">
        <div>
            <span class="badge">Detail Kontak</span>
            <h1 class="h1-display">{{ $contact->name ?: $contact->wa_name ?: $contact->phone_number }}</h1>
        </div>
        <a class="button button-secondary" href="{{ route('hotline.dashboard') }}">&larr; Kembali</a>
    </div>

    <div class="grid grid-2">
        <div class="card section stack" style="gap: 16px;">
            <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:8px;">Informasi Kontak</h3>
            <div class="detail-list">
                <div style="margin-bottom: 12px; font-size:14px;"><strong class="muted" style="font-size:11px; text-transform:uppercase; letter-spacing:0.88px; display:block;">Nomor WA</strong>{{ $contact->phone_number }}</div>
                <div style="margin-bottom: 12px; font-size:14px;"><strong class="muted" style="font-size:11px; text-transform:uppercase; letter-spacing:0.88px; display:block;">Semester</strong>{{ $contact->semester ?: '-' }}</div>
                <div style="margin-bottom: 12px; font-size:14px;"><strong class="muted" style="font-size:11px; text-transform:uppercase; letter-spacing:0.88px; display:block;">Kampus</strong>{{ $contact->campus ?: '-' }}</div>
                <div style="margin-bottom: 12px; font-size:14px;"><strong class="muted" style="font-size:11px; text-transform:uppercase; letter-spacing:0.88px; display:block;">Jurusan</strong>{{ $contact->major ?: '-' }}</div>
                <div style="margin-bottom: 12px; font-size:14px;"><strong class="muted" style="font-size:11px; text-transform:uppercase; letter-spacing:0.88px; display:block;">Referral</strong>{{ $contact->referral_code ?: '-' }}</div>
                <div style="margin-bottom: 12px; font-size:14px;"><strong class="muted" style="font-size:11px; text-transform:uppercase; letter-spacing:0.88px; display:block;">Group</strong><span class="pill">Group {{ $contact->group_type ?: '-' }}</span></div>
                <div style="margin-bottom: 12px; font-size:14px;"><strong class="muted" style="font-size:11px; text-transform:uppercase; letter-spacing:0.88px; display:block;">State Chatbot</strong><code>{{ $contact->chat_state }}</code></div>
            </div>
        </div>

        <div class="card section">
            <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Tindak Lanjut Admin</h3>
            <form method="post" action="{{ route('hotline.contacts.follow-up', $contact) }}" class="stack">
                @csrf
                @method('PATCH')
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label>Nama Admin</label>
                    <input type="text" name="admin_name" value="{{ optional($contact->followUps->first())->admin_name }}" placeholder="Contoh: Rina">
                </div>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label>Status</label>
                    <select name="status">
                        @php
                            $currentStatus = optional($contact->followUps->first())->status ?: 'pending';
                        @endphp
                        <option value="pending" @selected($currentStatus === 'pending')>Pending</option>
                        <option value="in_progress" @selected($currentStatus === 'in_progress')>In Progress</option>
                        <option value="done" @selected($currentStatus === 'done')>Done</option>
                    </select>
                </div>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label>Catatan</label>
                    <textarea name="notes" rows="4" placeholder="Catatan follow up admin">{{ optional($contact->followUps->first())->notes }}</textarea>
                </div>
                <div>
                    <button class="button button-primary" type="submit" style="width: 100%;">Simpan Tindak Lanjut</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card section">
        <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Riwayat Pesan Chat</h3>
        <table class="table">
            <thead>
                <tr>
                    <th style="width:120px;">Arah</th>
                    <th>Pesan</th>
                    <th style="width:180px;">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contact->messages as $message)
                    <tr>
                        <td>
                            <span class="pill" style="{{ $message->direction === 'incoming' ? 'background:#d8ecd9; color:#125d38;' : 'background:#e6e5e0; color:#5a5852;' }}">
                                {{ $message->direction }}
                            </span>
                        </td>
                        <td>{{ $message->body }}</td>
                        <td class="muted">{{ $message->sent_at?->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="muted" style="text-align: center; padding: 24px 0;">Belum ada pesan masuk/keluar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card section">
        <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Log Event Analisis</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Jenis Event</th>
                    <th>Referensi</th>
                    <th style="width:180px;">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contact->analyticsEvents as $event)
                    <tr>
                        <td><code>{{ $event->event_type }}</code></td>
                        <td>{{ $event->reference ?: '-' }}</td>
                        <td class="muted">{{ $event->occurred_at?->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="muted" style="text-align: center; padding: 24px 0;">Belum ada event analitik terekam.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
