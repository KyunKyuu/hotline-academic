@extends('layouts.marketing')

@section('content')

<section class="relative isolate overflow-hidden bg-surface-dark py-28 text-on-dark sm:py-36">
    <div class="pattern-lattice absolute inset-0 text-on-dark/[0.05]"></div>

    <div class="container-app relative">
        <a href="{{ route('landing.index') }}#komunitas" class="inline-flex items-center gap-2 text-sm font-medium text-on-dark-soft transition hover:text-on-dark">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 19l-7-7 7-7M4 12h16" /></svg>
            Kembali ke Komunitas &amp; Mitra
        </a>

        <span class="mt-8 inline-flex items-center gap-2 rounded-pill bg-surface-dark-elevated px-4 py-1.5 text-xs font-medium uppercase tracking-[0.14em] text-on-dark-soft">
            <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
            {{ $partner['tagline'] }}
        </span>

        <h1 class="mt-6 max-w-3xl font-serif text-5xl leading-tight tracking-tight text-balance sm:text-7xl">
            {{ $partner['name'] }}
        </h1>
    </div>
</section>

<section class="py-24 sm:py-32">
    <div class="container-app grid gap-14 lg:grid-cols-[1fr_1.3fr] lg:gap-20">
        <div>
            <x-photo-frame :item="$partner['logo']" path="partners" class="aspect-square rounded-lg" />
        </div>

        <div>
            <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Profil Komunitas</span>
            <p class="mt-6 text-xl leading-relaxed text-body">{{ $partner['profile'] }}</p>

            <div class="mt-16">
                <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Kegiatan Komunitas</span>
                <div class="mt-8 divide-y divide-hairline border-t border-hairline">
                    @foreach ($partner['activities'] as $index => $activity)
                        <div class="grid gap-3 py-8 sm:grid-cols-12 sm:items-baseline sm:gap-6">
                            <span class="font-serif text-3xl text-primary sm:col-span-2">0{{ $index + 1 }}</span>
                            <h3 class="text-xl font-medium text-ink sm:col-span-4">{{ $activity['title'] }}</h3>
                            <p class="text-lg leading-relaxed text-body sm:col-span-6">{{ $activity['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-28 sm:pb-36">
    <div class="container-app">
        <div class="rounded-2xl bg-primary px-8 py-16 text-center sm:px-20">
            <h2 class="mx-auto max-w-xl font-serif text-3xl leading-tight tracking-tight text-on-primary text-balance sm:text-4xl">
                Tertarik berkolaborasi seperti {{ $partner['name'] }}?
            </h2>
            <div class="mt-8">
                <a href="{{ route('landing.whatsapp.redirect', ['source' => 'community_'.$partner['slug'], 'campaign' => 'ajukan_kolaborasi']) }}"
                   class="inline-flex h-12 items-center justify-center rounded-md bg-canvas px-7 text-sm font-medium text-ink transition hover:bg-surface-soft">
                    Ajukan Kolaborasi
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
