@extends('layouts.app')

@section('content')
<div class="stack">
    <div>
        <span class="badge">Chatbot</span>
        <h1 class="h1-display">Kode Referral</h1>
        <p class="muted">Kelola daftar kode referral rahasia yang digunakan oleh chatbot WhatsApp untuk A/B grouping leads.</p>
    </div>

    @if(session('status'))
        <div class="card section" style="background: #e6f4ea; border-color: #34a853; color: #137333; padding: 16px; border-radius: 8px;">
            <strong>Sukses!</strong> {{ session('status') }}
        </div>
    @endif

    <div class="card section">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: normal;">Daftar Kode</h2>
            <a href="{{ route('admin.hotline.referrals.create') }}" class="button button-primary">+ Tambah Kode</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width:180px;">Kode Referral</th>
                    <th style="width:180px;">Nama Referral</th>
                    <th>Keterangan (Rahasia Admin)</th>
                    <th style="width:150px; text-align:center;">Jumlah Penggunaan</th>
                    <th style="width:180px; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($referrals as $ref)
                    <tr>
                        <td style="vertical-align:middle;">
                            <code style="font-size:15px; font-weight: 600; padding: 4px 8px; background: var(--surface-2); border: 1px solid var(--hairline); border-radius: 6px; color: var(--primary);">
                                {{ $ref->code }}
                            </code>
                        </td>
                        <td style="vertical-align:middle;"><strong>{{ $ref->name }}</strong></td>
                        <td style="vertical-align:middle; color: var(--ink-subtle);">{{ $ref->description ?: '-' }}</td>
                        <td style="vertical-align:middle; text-align:center; font-weight: 600;">{{ $ref->usage_count }}</td>
                        <td style="vertical-align:middle; text-align:right;">
                            <div style="display:inline-flex; gap:8px;">
                                <a href="{{ route('admin.hotline.referrals.edit', $ref) }}" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px;">Edit</a>
                                <form method="post" action="{{ route('admin.hotline.referrals.destroy', $ref) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kode referral ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px; color:#d93025; border-color:#fad2cf;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="muted" style="text-align: center; padding: 24px 0;">Belum ada kode referral yang terdaftar. Semua user akan masuk ke Group B secara default.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($referrals->hasPages())
            <div style="margin-top: 24px;">
                {{ $referrals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
