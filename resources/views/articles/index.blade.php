@extends('layouts.marketing')

@section('content')

<section class="relative isolate overflow-hidden bg-surface-dark py-28 text-on-dark sm:py-36">
    <div class="pattern-lattice absolute inset-0 text-on-dark/[0.05]"></div>
    <div class="container-app relative">
        <span class="text-sm font-medium uppercase tracking-[0.15em] text-accent-amber">Artikel &amp; Berita</span>
        <h1 class="mt-6 max-w-2xl font-serif text-5xl leading-tight tracking-tight text-balance sm:text-7xl">
            Kabar kegiatan MLUP Academy
        </h1>
    </div>
</section>

<section class="py-24 sm:py-32">
    <div class="container-app">
        @if ($articles->isEmpty())
            <div class="rounded-2xl bg-surface-soft px-8 py-24 text-center">
                <p class="text-xl text-body">Belum ada artikel yang dipublikasikan.</p>
            </div>
        @else
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <a href="{{ route('articles.show', $article) }}" class="group flex flex-col overflow-hidden rounded-lg border border-hairline bg-canvas shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="relative aspect-[16/10] overflow-hidden bg-surface-card">
                            @if ($article->cover_image)
                                <img src="{{ asset('images/articles/'.$article->cover_image) }}" alt="{{ $article->title }}" loading="lazy" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                            @else
                                <div class="photo-frame absolute inset-0 text-ink/[0.06]"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <x-brand-mark class="h-12 w-12 opacity-60" />
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <p class="text-xs font-medium uppercase tracking-[0.1em] text-muted">{{ $article->published_at->translatedFormat('d F Y') }}</p>
                            <h2 class="mt-3 font-serif text-xl text-ink">{{ $article->title }}</h2>
                            @if ($article->excerpt)
                                <p class="mt-2 flex-1 text-sm leading-relaxed text-body">{{ $article->excerpt }}</p>
                            @endif
                            <span class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-primary">
                                Baca selengkapnya
                                <x-icon name="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1" />
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-14">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</section>

@endsection
