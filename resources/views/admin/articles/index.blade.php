@extends('layouts.app')

@section('content')
    <section style="padding: 12px 0 48px;">
        <div class="container stack">
            <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
                <div>
                    <span class="badge">Kelola Artikel</span>
                    <h1 style="margin:12px 0 0;">Artikel &amp; berita kegiatan MLUP Academy.</h1>
                </div>
                <a href="{{ route('admin.articles.create') }}" class="button button-primary">Tulis Artikel</a>
            </div>

            @if (session('status'))
                <div class="card section">{{ session('status') }}</div>
            @endif

            <div class="card section">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Tanggal Terbit</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($articles as $article)
                            <tr>
                                <td>{{ $article->title }}</td>
                                <td>
                                    <span class="pill">{{ $article->isPublished() ? 'Terbit' : 'Draft' }}</span>
                                </td>
                                <td>{{ optional($article->published_at)->format('d M Y') ?: '-' }}</td>
                                <td style="display:flex;gap:12px;">
                                    <a href="{{ route('admin.articles.edit', $article) }}">Edit</a>
                                    <form method="post" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:none;border:none;color:#b04a3f;cursor:pointer;padding:0;font:inherit;">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="muted">Belum ada artikel. Klik "Tulis Artikel" untuk membuat yang pertama.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div style="margin-top:18px;">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
