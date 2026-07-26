@extends('layouts.app')

@section('content')
<div class="stack">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px;">
        <div>
            <span class="badge">Kelola Artikel</span>
            <h1 class="h1-display">Daftar Artikel</h1>
            <p class="muted">Tulis, edit, dan kelola berita kegiatan akademik serta keislaman MLUP Academy.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="button button-primary">+ Tulis Artikel</a>
    </div>

    @if (session('status'))
        <div class="card section" style="background: #e6f4ea; border-color: #34a853; color: #137333; padding: 16px; border-radius: 8px;">
            <strong>Sukses!</strong> {{ session('status') }}
        </div>
    @endif

    <div class="card section">
        <table class="table">
            <thead>
                <tr>
                    <th>Judul Artikel</th>
                    <th style="width:120px;">Status</th>
                    <th style="width:180px;">Tanggal Terbit</th>
                    <th style="width:150px; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td style="vertical-align:middle;">
                            <strong>{{ $article->title }}</strong>
                        </td>
                        <td style="vertical-align:middle;">
                            <span class="pill" style="{{ $article->isPublished() ? 'background:#d8ecd9; color:#125d38;' : 'background:#efeee8; color:#5a5852;' }}">
                                {{ $article->isPublished() ? 'Terbit' : 'Draft' }}
                            </span>
                        </td>
                        <td style="vertical-align:middle;" class="muted">{{ optional($article->published_at)->format('d M Y H:i') ?: '-' }}</td>
                        <td style="vertical-align:middle; text-align:right;">
                            <div style="display:inline-flex; gap:8px;">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px;">Edit</a>
                                <form method="post" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px; color:#d93025; border-color:#fad2cf;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="muted" style="text-align: center; padding: 24px 0;">Belum ada artikel. Klik "Tulis Artikel" untuk membuat yang pertama.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection
