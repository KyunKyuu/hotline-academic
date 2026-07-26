@extends('layouts.app')

@section('content')
<div class="stack" style="max-width: 880px;">
    <div>
        <a href="{{ route('admin.articles.index') }}" class="mini" style="text-decoration:none; color: var(--primary); font-weight: 500;">&larr; Kembali ke Kelola Artikel</a>
        <h1 class="h1-display" style="margin-top: 12px; margin-bottom: 8px;">{{ $article->exists ? 'Edit Artikel' : 'Tulis Artikel Baru' }}</h1>
        <p class="muted">Tulis konten edukasi keislaman dan berita kegiatan yang menarik.</p>
    </div>

    @if ($errors->any())
        <div class="card section" style="background: var(--danger-bg); border-color: var(--danger-line); color: var(--danger-text); padding: 16px; border-radius: 8px;">
            <h3 style="margin-top:0; font-size: 16px;">Ada kesalahan input:</h3>
            <ul style="margin:0; padding-left:20px; font-size: 14px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card section">
        <form method="post" action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data" class="stack">
            @csrf
            @if ($article->exists)
                @method('PUT')
            @endif

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title', $article->title) }}" placeholder="Contoh: Manfaat Belajar Adab Sebelum Ilmu" required>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Ringkasan Pendek (Maks. 300 karakter)</label>
                <textarea name="excerpt" rows="2" maxlength="300" placeholder="Ringkasan singkat artikel untuk dihalaman depan...">{{ old('excerpt', $article->excerpt) }}</textarea>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Isi Lengkap Artikel</label>
                <textarea name="body" rows="12" placeholder="Tuliskan seluruh isi artikel di sini..." required>{{ old('body', $article->body) }}</textarea>
            </div>

            <div class="grid grid-2">
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label style="font-weight:600;">Foto Sampul (Cover)</label>
                    <input type="file" name="cover" accept="image/*" style="padding: 8px;">
                    @if ($article->cover_image)
                        <div style="margin-top:6px;">
                            <span class="mini">File aktif: <a href="{{ asset('images/articles/' . $article->cover_image) }}" target="_blank" style="color: var(--primary); text-decoration: underline;">{{ $article->cover_image }}</a></span>
                        </div>
                    @endif
                </div>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label style="font-weight:600;">Tanggal Terbit</label>
                    <input type="datetime-local" name="published_at" style="padding: 10px;" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}">
                    <span class="mini" style="margin-top:2px;">Kosongkan jika ingin disimpan sebagai draft.</span>
                </div>
            </div>

            <div style="display:flex; gap:12px; margin-top:12px; border-top: 1px solid var(--hairline); padding-top:24px;">
                <button type="submit" class="button button-primary">Simpan Artikel</button>
                <a href="{{ route('admin.articles.index') }}" class="button button-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
