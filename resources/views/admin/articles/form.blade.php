@extends('layouts.app')

@section('content')
    <section style="padding: 12px 0 48px;">
        <div class="container stack">
            <div>
                <span class="badge">Kelola Artikel</span>
                <h1 style="margin:12px 0 0;">{{ $article->exists ? 'Edit Artikel' : 'Tulis Artikel Baru' }}</h1>
            </div>

            @if ($errors->any())
                <div class="card section">
                    <p class="muted">Periksa kembali isian berikut:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card section">
                <form method="post"
                      action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}"
                      enctype="multipart/form-data" class="stack">
                    @csrf
                    @if ($article->exists)
                        @method('PUT')
                    @endif

                    <div>
                        <label class="mini">Judul</label>
                        <input type="text" name="title" value="{{ old('title', $article->title) }}" required>
                    </div>

                    <div>
                        <label class="mini">Ringkasan (opsional, maks. 300 karakter)</label>
                        <textarea name="excerpt" rows="2" maxlength="300">{{ old('excerpt', $article->excerpt) }}</textarea>
                    </div>

                    <div>
                        <label class="mini">Isi Artikel</label>
                        <textarea name="body" rows="12" required>{{ old('body', $article->body) }}</textarea>
                    </div>

                    <div class="grid grid-2">
                        <div>
                            <label class="mini">Foto Sampul (opsional)</label>
                            <input type="file" name="cover" accept="image/*">
                            @if ($article->cover_image)
                                <p class="mini" style="margin-top:8px;">Sampul saat ini: {{ $article->cover_image }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="mini">Tanggal Terbit (kosongkan untuk simpan sebagai draft)</label>
                            <input type="datetime-local" name="published_at"
                                   value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}">
                        </div>
                    </div>

                    <div style="display:flex;gap:12px;">
                        <button type="submit" class="button button-primary">Simpan</button>
                        <a href="{{ route('admin.articles.index') }}" class="button button-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
