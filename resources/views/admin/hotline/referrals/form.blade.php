@extends('layouts.app')

@section('content')
<div class="stack" style="max-width: 680px;">
    <div>
        <a href="{{ route('admin.hotline.referrals.index') }}" class="mini" style="text-decoration:none; color: var(--primary); font-weight: 500;">&larr; Kembali ke Daftar Kode</a>
        <h1 class="h1-display" style="margin-top: 12px; margin-bottom: 8px;">{{ $referral->exists ? 'Edit Kode Referral' : 'Tambah Kode Referral' }}</h1>
        <p class="muted">Tentukan kode referral rahasia baru untuk disebarkan privat ke sasaran partner atau kelompok.</p>
    </div>

    @if($errors->any())
        <div class="card section" style="background: rgba(207, 45, 86, 0.1); border-color: var(--semantic-error); color: var(--semantic-error); padding: 16px; border-radius: 8px;">
            <h3 style="margin-top:0; font-size: 16px;">Ada kesalahan input:</h3>
            <ul style="margin:0; padding-left:20px; font-size: 14px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card section">
        <form method="post" action="{{ $referral->exists ? route('admin.hotline.referrals.update', $referral) : route('admin.hotline.referrals.store') }}" class="stack">
            @csrf
            @if($referral->exists)
                @method('PUT')
            @endif

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Kode Referral</label>
                <input type="text" name="code" value="{{ old('code', $referral->code) }}" placeholder="Contoh: REF-VIP01" style="text-transform: uppercase;" required>
                <span class="mini">Spasi akan dihapus otomatis dan kode akan diubah menjadi huruf besar (case-insensitive).</span>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Nama Referral</label>
                <input type="text" name="name" value="{{ old('name', $referral->name) }}" placeholder="Contoh: ITENAS" required>
                <span class="mini">Nama label yang akan ditambahkan pada nama grup (misalnya: Group A (ITENAS)).</span>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Keterangan (Rahasia Admin)</label>
                <input type="text" name="description" value="{{ old('description', $referral->description) }}" placeholder="Contoh: Dibagikan ke BEM Kampus X untuk mahasiswa berprestasi">
                <span class="mini">Keterangan ini hanya bisa dibaca oleh admin sebagai catatan penyebaran kode.</span>
            </div>

            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="button button-primary">{{ $referral->exists ? 'Perbarui Kode' : 'Tambah Kode' }}</button>
                <a href="{{ route('admin.hotline.referrals.index') }}" class="button button-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
