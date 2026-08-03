@extends('layouts.app')

@section('content')
<div class="stack" style="max-width: 680px;">
    <div>
        <a href="{{ route('admin.landing.testimonials.index') }}" class="mini" style="text-decoration:none; color: var(--primary); font-weight: 500;">&larr; Kembali ke Daftar Cerita</a>
        <h1 class="h1-display" style="margin-top: 12px; margin-bottom: 8px;">{{ $testimonial->exists ? 'Edit Cerita Peserta' : 'Tambah Cerita Peserta' }}</h1>
        <p class="muted">Tulis cerita, status, nama, dan instansi/detail peserta untuk ditampilkan di Landing Page.</p>
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
        <form method="post" action="{{ $testimonial->exists ? route('admin.landing.testimonials.update', $testimonial) : route('admin.landing.testimonials.store') }}" class="stack">
            @csrf
            @if($testimonial->exists)
                @method('PUT')
            @endif

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Nama Peserta</label>
                <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" placeholder="Contoh: A., Mahasiswi S1" required>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Konteks / Detail Instansi</label>
                <input type="text" name="context" value="{{ old('context', $testimonial->context) }}" placeholder="Contoh: Semester 9 · Hambatan penulisan skripsi" required>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Isi Cerita / Pesan</label>
                <textarea name="message" rows="6" placeholder="Tuliskan detail cerita di sini..." required>{{ old('message', $testimonial->message) }}</textarea>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Karakter Avatar (Simbol / Emoji)</label>
                <input type="text" name="avatar" value="{{ old('avatar', $testimonial->exists ? $testimonial->avatar : '✦') }}" placeholder="Contoh: ✦ atau ◈ atau emoji 🌸" required>
                <span class="mini">Gunakan satu simbol atau satu emoji sebagai visual pembeda di Landing Page.</span>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Urutan Tampilan</label>
                <input type="number" name="order" value="{{ old('order', $testimonial->exists ? $testimonial->order : 0) }}" required>
            </div>

            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="button button-primary">{{ $testimonial->exists ? 'Perbarui Cerita' : 'Tambah Cerita' }}</button>
                <a href="{{ route('admin.landing.testimonials.index') }}" class="button button-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
