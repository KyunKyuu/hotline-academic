@extends('layouts.app')

@section('content')
<div class="stack" style="max-width: 680px;">
    <div>
        <a href="{{ route('admin.landing.moments.index') }}" class="mini" style="text-decoration:none; color: var(--primary); font-weight: 500;">&larr; Kembali ke Momen Kegiatan</a>
        <h1 class="h1-display" style="margin-top: 12px; margin-bottom: 8px;">{{ $moment->exists ? 'Edit Momen Kegiatan' : 'Tambah Momen Kegiatan' }}</h1>
        <p class="muted">Tentukan gambar dan keterangan penjelas momen kegiatan komunitas.</p>
    </div>

    @if($errors->any())
        <div class="card section" style="background: var(--danger-bg); border-color: var(--danger-line); color: var(--danger-text); padding: 16px; border-radius: 8px;">
            <h3 style="margin-top:0; font-size: 16px;">Ada kesalahan input:</h3>
            <ul style="margin:0; padding-left:20px; font-size: 14px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card section">
        <form method="post" action="{{ $moment->exists ? route('admin.landing.moments.update', $moment) : route('admin.landing.moments.store') }}" enctype="multipart/form-data" class="stack">
            @csrf
            @if($moment->exists)
                @method('PUT')
            @endif

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Gambar Momen</label>
                <input type="file" name="image" accept="image/*" style="padding: 8px;" {{ $moment->exists ? '' : 'required' }}>
                @if($moment->image)
                    <div style="margin-top:8px;">
                        <span class="mini" style="display:block; margin-bottom:4px;">Gambar saat ini:</span>
                        <img src="{{ asset('images/gallery/' . $moment->image) }}" alt="Current image" style="max-width:240px; border-radius:6px; border:1px solid var(--hairline);">
                    </div>
                @endif
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Caption (Keterangan Gambar)</label>
                <input type="text" name="caption" value="{{ old('caption', $moment->caption) }}" placeholder="Contoh: Kelas mentoring akademik" required>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Urutan Tampilan</label>
                <input type="number" name="order" value="{{ old('order', $moment->exists ? $moment->order : 0) }}" required>
            </div>

            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="button button-primary">{{ $moment->exists ? 'Perbarui Momen' : 'Tambah Momen' }}</button>
                <a href="{{ route('admin.landing.moments.index') }}" class="button button-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
