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
        <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Riwayat Chat WhatsApp</h3>
        
        <div style="background: #0b141a; border-radius: 12px; border: 1px solid var(--hairline); padding: 24px; display: flex; flex-direction: column; gap: 16px; max-height: 480px; overflow-y: auto;">
            @forelse($contact->messages->reverse() as $message)
                @if($message->direction === 'inbound')
                    <!-- Student message (Left) -->
                    <div style="display: flex; flex-direction: column; align-self: flex-start; max-width: 70%;">
                        <div style="background: #202c33; color: var(--ink); padding: 10px 14px; border-radius: 0px 12px 12px 12px; font-size: 14.5px; line-height: 1.5; box-shadow: 0 1px 2px rgba(0,0,0,0.15); word-break: break-word; white-space: pre-wrap;">{{ $message->body }}</div>
                        <span style="font-size: 11px; color: var(--ink-subtle); margin-top: 4px; padding-left: 4px;">{{ $message->sent_at?->format('d M Y H:i') }}</span>
                    </div>
                @else
                    <!-- Bot/Admin message (Right) -->
                    <div style="display: flex; flex-direction: column; align-self: flex-end; max-width: 70%; align-items: flex-end;">
                        <div style="background: #005c4b; color: #e9edef; padding: 10px 14px; border-radius: 12px 0px 12px 12px; font-size: 14.5px; line-height: 1.5; box-shadow: 0 1px 2px rgba(0,0,0,0.15); word-break: break-word; white-space: pre-wrap;">{{ $message->body }}</div>
                        <span style="font-size: 11px; color: var(--ink-subtle); margin-top: 4px; padding-right: 4px;">{{ $message->sent_at?->format('d M Y H:i') }}</span>
                    </div>
                @endif
            @empty
                <p class="muted" style="text-align: center; padding: 24px 0; width: 100%;">Belum ada riwayat pesan chat.</p>
            @endforelse
        </div>
    </div>


</div>
@endsection
