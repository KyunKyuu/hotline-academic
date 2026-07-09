@extends('layouts.marketing')

@section('content')

<article>
    <section class="relative isolate overflow-hidden bg-surface-dark py-28 text-on-dark sm:py-36">
        <div class="pattern-lattice absolute inset-0 text-on-dark/[0.05]"></div>
        <div class="container-app relative">
            <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-on-dark-soft transition hover:text-on-dark">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 19l-7-7 7-7M4 12h16" /></svg>
                Kembali ke Artikel &amp; Berita
            </a>

            <p class="mt-8 text-sm font-medium uppercase tracking-[0.14em] text-accent-amber">{{ $article->published_at->translatedFormat('d F Y') }}</p>
            <h1 class="mt-4 max-w-3xl font-serif text-4xl leading-tight tracking-tight text-balance sm:text-6xl">
                {{ $article->title }}
            </h1>
        </div>
    </section>

    <section class="py-24 sm:py-32">
        <div class="container-app">
            <div class="mx-auto max-w-3xl">
                @if ($article->cover_image)
                    <div class="mb-12 aspect-[16/9] overflow-hidden rounded-lg bg-surface-card">
                        <img src="{{ asset('images/articles/'.$article->cover_image) }}" alt="{{ $article->title }}" class="h-full w-full object-cover">
                    </div>
                @endif

                <div class="space-y-6 text-lg leading-relaxed text-body">
                    @foreach (preg_split('/\n{2,}/', trim($article->body)) as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="bg-surface-soft py-24 sm:py-32">
            <div class="container-app">
                <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Artikel Lainnya</span>
                <div class="mt-8 grid gap-6 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('articles.show', $item) }}" class="group rounded-lg border border-hairline bg-canvas p-6 transition hover:-translate-y-1 hover:shadow-lg">
                            <p class="text-xs font-medium uppercase tracking-[0.1em] text-muted">{{ $item->published_at->translatedFormat('d F Y') }}</p>
                            <h3 class="mt-3 font-serif text-lg text-ink">{{ $item->title }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="py-24 sm:py-32">
        <div class="container-app">
            <div class="rounded-2xl bg-primary px-8 py-16 text-center sm:px-16">
                <h2 class="mx-auto max-w-xl font-serif text-3xl leading-tight tracking-tight text-on-primary text-balance sm:text-4xl">
                    Ingin jadi bagian dari kegiatan berikutnya?
                </h2>
                <a href="{{ route('landing.whatsapp.redirect', ['source' => 'article_'.$article->slug, 'campaign' => 'gabung_komunitas']) }}"
                   class="mt-8 inline-flex h-12 items-center justify-center rounded-md bg-canvas px-7 text-sm font-medium text-ink transition hover:bg-surface-soft">
                    Gabung Komunitas
                </a>
            </div>
        </div>
    </section>
</article>

@endsection
