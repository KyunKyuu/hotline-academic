@extends('layouts.marketing')

@section('content')

{{-- ============ HERO — full-bleed, image-led ============ --}}
<section class="relative isolate flex min-h-[100svh] items-end overflow-hidden bg-surface-dark text-on-dark">
    <div class="absolute inset-0">
        @if ($heroVideoExists)
            <video autoplay muted loop playsinline class="absolute inset-0 h-full w-full object-cover">
                <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-surface-dark/50"></div>
        @else
            <div class="pattern-lattice absolute inset-0 text-on-dark/[0.05]"></div>

            <svg viewBox="0 0 800 800" preserveAspectRatio="xMidYMid slice"
                 class="absolute left-1/2 top-1/2 h-[130%] w-[130%] -translate-x-1/2 -translate-y-1/2 text-primary/25 sm:h-[110%] sm:w-[110%]">
                <circle cx="560" cy="230" r="150" fill="none" stroke="currentColor" stroke-width="2" />
                <path d="M 560 90 A 150 150 0 1 0 690 300 A 118 118 0 1 1 560 90 Z" fill="currentColor" opacity="0.9" />
                <g stroke="currentColor" stroke-width="1.6" opacity="0.5">
                    <path d="M120 640 h230" />
                    <path d="M120 590 h230 v230 h-230 Z" />
                    <path d="M150 590 v-40 M320 590 v-40" stroke-width="10" stroke-linecap="round" />
                    <path d="M235 550 v-90 M180 500 h110" />
                </g>
                <g stroke="currentColor" stroke-width="1.2" opacity="0.4">
                    <path d="M400 60 L410 95 L446 100 L419 124 L427 160 L400 140 L373 160 L381 124 L354 100 L390 95 Z" />
                </g>
            </svg>
        @endif

        <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-surface-dark via-surface-dark/85 to-transparent"></div>
        <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-surface-dark/70 to-transparent"></div>
    </div>

    <div class="container-app relative z-10 pb-16 pt-40 sm:pb-24">
        <span class="inline-flex items-center gap-2 rounded-pill bg-surface-dark-elevated px-4 py-1.5 text-xs font-medium uppercase tracking-[0.14em] text-on-dark-soft" data-reveal>
            <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
            Komunitas Pendidikan Muslim Indonesia
        </span>

        <h1 class="mt-8 max-w-4xl font-serif text-6xl leading-[1.02] tracking-tight text-balance sm:text-7xl lg:text-[6rem]" data-reveal data-reveal-delay="1">
            Unggul dalam Ilmu.
            <span class="block italic text-primary">Kuat dalam Iman.</span>
        </h1>

        <p class="mt-8 max-w-lg text-xl leading-relaxed text-on-dark-soft" data-reveal data-reveal-delay="2">
            Satu ruang belajar bagi pelajar dan mahasiswa muslim Indonesia — tempat akademik dan keislaman tumbuh bersama.
        </p>

        <div class="mt-10 flex flex-wrap items-center gap-4" data-reveal data-reveal-delay="3">
            <a href="{{ route('landing.whatsapp.redirect', ['source' => 'hero', 'campaign' => 'gabung_komunitas']) }}"
               class="inline-flex h-14 items-center justify-center rounded-md bg-primary px-8 text-base font-medium text-on-primary shadow-sm transition hover:bg-primary-active">
                Gabung Komunitas
            </a>
            <a href="#tentang" class="inline-flex h-14 items-center justify-center rounded-md border border-white/15 px-8 text-base font-medium text-on-dark transition hover:bg-white/5">
                Kenali Kami
            </a>
        </div>
    </div>

    <a href="#tentang" class="absolute bottom-8 left-1/2 z-10 hidden -translate-x-1/2 flex-col items-center gap-2 text-on-dark-soft sm:flex">
        <span class="text-xs uppercase tracking-[0.2em]">Gulir</span>
        <svg class="h-4 w-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19 9l-7 7-7-7" /></svg>
    </a>
</section>

{{-- ============ MARQUEE ============ --}}
<div class="overflow-hidden border-y border-hairline bg-surface-soft py-5">
    <div class="flex w-max animate-marquee gap-12 whitespace-nowrap">
        @for ($i = 0; $i < 2; $i++)
            @foreach ($fields as $field)
                <span class="flex items-center gap-4 text-base font-medium uppercase tracking-[0.1em] text-muted">
                    {{ $field }}
                    <span class="h-1.5 w-1.5 rounded-full bg-primary/60"></span>
                </span>
            @endforeach
        @endfor
    </div>
</div>

{{-- ============ LATAR BELAKANG ============ --}}
<section class="relative overflow-hidden py-28 sm:py-36">
    <x-leaf class="pointer-events-none absolute -right-6 top-16 hidden h-64 w-64 rotate-[18deg] text-ink/[0.04] lg:block" />

    <div class="container-app relative">
        <div class="max-w-3xl" data-reveal>
            <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Latar Belakang</span>
            <p class="mt-6 font-serif text-3xl leading-snug tracking-tight text-ink text-balance sm:text-5xl">
                Lahir dari keresahan terhadap kondisi dunia akademik muslim Indonesia — biaya yang terus naik, mentoring
                yang belum merata, dan paradigma lama yang memisahkan keunggulan akademik dari kekuatan iman.
            </p>
        </div>

        <div class="mt-20 divide-y divide-hairline border-t border-hairline">
            @foreach ($problems as $index => $problem)
                <div class="grid gap-4 py-10 sm:grid-cols-12 sm:items-baseline sm:gap-8" data-reveal data-reveal-delay="{{ min($index + 1, 5) }}">
                    <span class="font-serif text-4xl text-primary sm:col-span-2">0{{ $index + 1 }}</span>
                    <h3 class="text-2xl font-medium text-ink sm:col-span-4">{{ $problem['title'] }}</h3>
                    <p class="text-lg leading-relaxed text-body sm:col-span-6">{{ $problem['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container-app mt-24" data-reveal>
        <div class="relative overflow-hidden rounded-2xl bg-primary px-8 py-20 text-center sm:px-20">
            <div class="pattern-lattice absolute inset-0 text-on-primary/10"></div>
            <x-icon name="quote" class="relative mx-auto h-12 w-12 text-on-primary/40" />
            <p class="relative mx-auto mt-8 max-w-3xl font-serif text-3xl italic leading-snug text-on-primary text-balance sm:text-5xl">
                Akademik dan keislaman dapat tumbuh bersama, dalam satu ekosistem yang sama.
            </p>
            <div class="relative mx-auto mt-8 flex items-center justify-center gap-3">
                <span class="h-px w-10 bg-on-primary/40"></span>
                <p class="text-sm font-medium uppercase tracking-[0.15em] text-on-primary/80">Keyakinan Dasar MLUP Academy</p>
                <span class="h-px w-10 bg-on-primary/40"></span>
            </div>
        </div>
    </div>
</section>

{{-- ============ SIAPA KAMI — alternating image/text rows ============ --}}
<section id="tentang" class="scroll-mt-20 bg-surface-soft py-28 sm:py-36">
    <div class="container-app">
        <div class="max-w-2xl" data-reveal>
            <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Siapa Kami</span>
            <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-6xl">
                Bukan lembaga formal — ruang belajar yang inklusif
            </h2>
            <p class="mt-6 text-xl leading-relaxed text-body">
                Mempertemukan pelajar, mahasiswa, dan pejuang akademik muslim tanpa membedakan latar belakang maupun
                kemampuan ekonomi. Untuk pelajar, mahasiswa, Gen-Z, profesional muda, hingga donatur.
            </p>
        </div>

        <div class="mt-24 space-y-24">
            @foreach ($approaches as $index => $approach)
                <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16 {{ $index % 2 === 1 ? 'lg:[&>*:first-child]:order-2' : '' }}" data-reveal>
                    <x-photo-frame :item="$approachPhotos[$index]" class="aspect-[4/3] rounded-lg" />
                    <div>
                        <span class="font-serif text-lg text-muted">{{ $approach['label'] }}</span>
                        <h3 class="mt-3 font-serif text-4xl text-ink sm:text-5xl">{{ $approach['title'] }}</h3>
                        <p class="mt-5 max-w-lg text-lg leading-relaxed text-body">{{ $approach['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ VISI (statement band) ============ --}}
<section id="visi-misi" class="relative scroll-mt-20 overflow-hidden bg-surface-dark py-28 text-on-dark sm:py-40">
    <x-leaf class="pointer-events-none absolute -left-10 top-10 hidden h-56 w-56 -rotate-[24deg] text-on-dark/[0.06] xl:block" />
    <x-leaf class="pointer-events-none absolute -right-8 bottom-10 hidden h-72 w-72 rotate-[32deg] text-on-dark/[0.06] xl:block" />

    <div class="container-app relative text-center">
        <span class="text-sm font-medium uppercase tracking-[0.15em] text-accent-amber" data-reveal>Visi</span>
        <p class="mx-auto mt-8 max-w-4xl font-serif text-4xl leading-tight tracking-tight text-balance sm:text-6xl" data-reveal data-reveal-delay="1">
            Membangun generasi muslim Indonesia yang menjadi <span class="italic text-primary">rujukan dalam keilmuan</span>
            dan <span class="italic text-primary">teladan dalam keislaman</span>.
        </p>
        <p class="mx-auto mt-8 max-w-xl text-xl text-on-dark-soft" data-reveal data-reveal-delay="2">
            Melalui ruang belajar yang terbuka bagi siapa pun, tanpa diskriminasi.
        </p>
    </div>

    {{-- Paradigma lama vs baru — interactive tabs --}}
    <div class="container-app mt-20" x-data="tabSwitcher(0)" data-reveal data-reveal-delay="3">
        <div class="flex flex-wrap justify-center gap-3">
            @foreach ($paradigms as $index => $paradigm)
                <button @click="active = {{ $index }}"
                        :class="isActive({{ $index }}) ? 'bg-primary text-on-primary' : 'bg-surface-dark-elevated text-on-dark-soft hover:text-on-dark'"
                        class="rounded-pill px-6 py-3 text-base font-medium transition">
                    {{ $paradigm['topic'] }}
                </button>
            @endforeach
        </div>

        <div class="relative mx-auto mt-14 max-w-3xl">
            @foreach ($paradigms as $index => $paradigm)
                <div x-show="isActive({{ $index }})"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-[0.97] translate-y-3"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-[0.97] -translate-y-2"
                     x-cloak
                     class="relative overflow-hidden rounded-lg border-2 border-primary/40 bg-surface-dark-elevated">
                    <div class="pattern-lattice absolute inset-0 text-on-dark/[0.04]"></div>

                    <div class="relative flex items-center gap-3 border-b border-white/10 px-8 py-4 sm:px-10">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-primary text-xs font-medium text-on-primary">{{ $index + 1 }}</span>
                        <p class="text-sm font-medium text-on-dark">{{ $paradigm['topic'] }}</p>
                    </div>

                    <div class="relative grid gap-8 p-8 sm:grid-cols-2 sm:gap-0 sm:divide-x sm:divide-white/10 sm:p-10">
                        <div class="sm:pr-9">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-error/15 text-error">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </span>
                                <p class="text-xs font-medium uppercase tracking-[0.1em] text-on-dark-soft/70">Paradigma Lama</p>
                            </div>
                            <p class="mt-5 text-lg leading-relaxed text-on-dark-soft line-through decoration-error/60">{{ $paradigm['old'] }}</p>
                        </div>

                        <div class="sm:pl-9">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary/20 text-primary">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </span>
                                <p class="text-xs font-medium uppercase tracking-[0.1em] text-primary">Paradigma Baru</p>
                            </div>
                            <p class="mt-5 text-lg leading-relaxed text-on-dark">{{ $paradigm['new'] }}</p>
                        </div>
                    </div>

                    <span class="absolute left-1/2 top-1/2 z-10 hidden h-11 w-11 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-primary text-on-primary shadow-lg sm:flex">
                        <x-icon name="arrow-right" class="h-5 w-5" />
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ PILAR VISI — editorial list ============ --}}
<section class="py-28 sm:py-36">
    <div class="container-app">
        <div class="max-w-2xl" data-reveal>
            <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Pilar Visi</span>
            <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-6xl">
                Empat pilar yang menopang arah kami
            </h2>
        </div>

        <div class="mt-16 divide-y divide-hairline border-t border-hairline">
            @foreach ($pillars as $index => $pillar)
                <div class="grid gap-4 py-12 sm:grid-cols-12 sm:items-center sm:gap-8" data-reveal data-reveal-delay="{{ min($index + 1, 5) }}">
                    <span class="font-serif text-5xl text-primary/70 sm:col-span-2">{{ $index + 1 }}</span>
                    <h3 class="text-2xl font-medium leading-snug text-ink sm:col-span-4">{{ $pillar['title'] }}</h3>
                    <p class="text-lg leading-relaxed text-body sm:col-span-6">{{ $pillar['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ COLLAGE — decorative photo breather ============ --}}
<section class="overflow-hidden py-24 sm:py-32">
    <div class="container-app">
        <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10" data-reveal>
            <x-photo-frame :item="$decor[0]" class="aspect-[3/4] w-36 rotate-[-4deg] rounded-lg shadow-xl sm:w-48" />
            <x-photo-frame :item="$decor[1]" class="aspect-[3/4] w-44 rotate-[3deg] rounded-lg shadow-2xl sm:w-60 sm:-translate-y-5" />
            <x-photo-frame :item="$decor[2]" class="aspect-[3/4] w-36 rotate-[-2deg] rounded-lg shadow-xl sm:w-48" />
        </div>
    </div>
</section>

{{-- ============ MISI (accordion) ============ --}}
<section class="bg-surface-soft py-28 sm:py-36">
    <div class="container-app grid gap-14 lg:grid-cols-12">
        <div class="lg:col-span-4" data-reveal>
            <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Misi</span>
            <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-5xl">
                Empat misi yang kami jalankan
            </h2>
            <p class="mt-6 text-lg leading-relaxed text-body">Klik setiap misi untuk melihat langkah implementasinya.</p>
        </div>

        <div class="lg:col-span-8" x-data="accordionGroup(0)" data-reveal data-reveal-delay="1">
            @foreach ($missions as $index => $mission)
                <div class="border-b border-hairline py-7 first:pt-0">
                    <button @click="toggle({{ $index }})" class="flex w-full items-center justify-between gap-6 text-left">
                        <span class="flex items-baseline gap-5">
                            <span class="font-serif text-base text-muted">0{{ $index + 1 }}</span>
                            <span class="font-serif text-2xl text-ink sm:text-3xl">{{ $mission['title'] }}</span>
                        </span>
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-hairline text-ink transition"
                              :class="isOpen({{ $index }}) && 'rotate-45 bg-primary border-primary text-on-primary'">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4" /></svg>
                        </span>
                    </button>

                    <div x-show="isOpen({{ $index }})" x-collapse x-cloak class="pl-10 pt-5">
                        <p class="text-lg text-body">{{ $mission['summary'] }}</p>
                        <ul class="mt-5 space-y-3">
                            @foreach ($mission['points'] as $point)
                                <li class="flex items-start gap-3 text-base text-body">
                                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-primary"></span>
                                    {{ $point }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ MOMEN KEGIATAN — proof gallery ============ --}}
<section class="py-28 sm:py-36">
    <div class="container-app">
        <div class="max-w-2xl" data-reveal>
            <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Momen Kegiatan</span>
            <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-6xl">
                Bukan sekadar wacana — ini ruang belajarnya
            </h2>
        </div>

        {{-- Asymmetric editorial masonry — collapses to a single column on mobile --}}
        <div class="mt-12 grid grid-cols-1 gap-4 sm:mt-16 sm:grid-cols-[0.85fr_1.15fr] sm:gap-6">
            <div class="grid gap-4 sm:gap-6">
                <x-photo-frame :item="$proofGallery[0]" class="aspect-[4/5] rounded-lg shadow-md" />
                <x-photo-frame :item="$proofGallery[1]" class="aspect-[4/3] rounded-lg shadow-md" />
            </div>
            <div class="grid gap-4 sm:gap-6">
                <x-photo-frame :item="$proofGallery[2]" class="aspect-[16/10] rounded-lg shadow-md" />
                <div class="grid grid-cols-2 gap-4 sm:gap-6">
                    <x-photo-frame :item="$proofGallery[3]" class="aspect-[3/4] rounded-lg shadow-md" />
                    <x-photo-frame :item="$proofGallery[4]" class="aspect-[3/4] rounded-lg shadow-md" />
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ NILAI — alternating icon/text rows ============ --}}
<section id="nilai" class="scroll-mt-20 bg-surface-soft py-28 sm:py-36">
    <div class="container-app">
        <div class="max-w-2xl" data-reveal>
            <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Nilai-Nilai Organisasi</span>
            <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-6xl">
                Lima nilai yang melandasi setiap keputusan
            </h2>
        </div>

        <div class="mt-16 grid gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-start" x-data="{ active: 0 }" data-reveal>
            <div class="lg:sticky lg:top-28">
                <div class="relative mx-auto flex aspect-square w-full max-w-sm items-center justify-center overflow-hidden rounded-2xl shadow-lg transition-colors duration-500 lg:mx-0"
                     :class="{
                        'bg-ink': active === 0,
                        'bg-primary': active === 1,
                        'bg-accent-teal': active === 2,
                        'bg-accent-amber': active === 3,
                        'bg-accent-blue': active === 4,
                     }">
                    <div class="pattern-lattice absolute inset-0 text-white opacity-10"></div>
                    <span class="absolute -left-10 -top-10 h-44 w-44 rounded-full bg-white/10 blur-2xl"></span>
                    <span class="absolute -right-12 -bottom-12 h-56 w-56 rounded-full bg-black/10 blur-2xl"></span>
                    <span class="absolute left-7 top-7 font-serif text-sm text-white/70" x-text="'Nilai 0' + (active + 1)"></span>

                    @foreach ($values as $index => $value)
                        <div x-show="active === {{ $index }}"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-90"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-90"
                             x-cloak class="absolute">
                            <x-icon :name="$value['icon']" class="h-28 w-28 text-white sm:h-36 sm:w-36" />
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="divide-y divide-hairline border-t border-hairline">
                @foreach ($values as $index => $value)
                    <button @click="active = {{ $index }}" @mouseenter="active = {{ $index }}" type="button" class="block w-full text-left">
                        <div class="flex items-center justify-between gap-4 rounded-lg px-5 py-5 transition-colors duration-300" :class="active === {{ $index }} ? 'bg-surface-card' : ''">
                            <h3 class="font-serif text-xl sm:text-2xl" :class="active === {{ $index }} ? 'text-primary' : 'text-ink'">{{ $value['title'] }}</h3>
                            <svg class="h-5 w-5 shrink-0 text-muted transition-transform duration-300" :class="active === {{ $index }} ? 'rotate-90 text-primary' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7" /></svg>
                        </div>
                        <div x-show="active === {{ $index }}" x-collapse x-cloak class="px-5">
                            <p class="pb-5 pt-1 text-base leading-relaxed text-body">{{ $value['description'] }}</p>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ============ 06 · PORTOFOLIO PROGRAM ============ --}}
<section id="program" class="scroll-mt-20 py-28 sm:py-36">
    <div class="container-app">
        @if (count($programs) > 0)
            <div class="max-w-2xl" data-reveal>
                <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">06 &middot; Portofolio Program</span>
                <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-6xl">Yang telah kami buktikan</h2>
            </div>
            <div class="mt-16 grid gap-6 lg:grid-cols-3">
                @foreach ($programs as $program)
                    <div class="rounded-lg border border-hairline bg-canvas p-8">
                        <h3 class="font-serif text-2xl text-ink">{{ $program['title'] }}</h3>
                        <p class="mt-3 text-lg leading-relaxed text-body">{{ $program['description'] }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="relative overflow-hidden rounded-2xl bg-surface-dark px-8 py-24 text-center text-on-dark sm:px-20" data-reveal>
                <div class="pattern-lattice absolute inset-0 text-on-dark/[0.05]"></div>
                <span class="relative rounded-pill bg-surface-dark-elevated px-4 py-1.5 text-xs font-medium uppercase tracking-[0.12em] text-accent-amber">
                    06 &middot; Portofolio Program
                </span>
                <h2 class="relative mx-auto mt-8 max-w-2xl font-serif text-4xl leading-tight tracking-tight text-balance sm:text-5xl">
                    Yang telah kami buktikan sedang kami susun jadi satu portofolio utuh
                </h2>
                <p class="relative mx-auto mt-6 max-w-xl text-xl text-on-dark-soft">
                    Sambil menunggu, lihat <a href="#nilai" class="underline decoration-primary/60 underline-offset-4 hover:text-on-dark">bukti kegiatan kami</a> di atas — komunitas ini bukan sekadar wacana.
                </p>
                <a href="{{ route('landing.whatsapp.redirect', ['source' => 'program_teaser', 'campaign' => 'gabung_komunitas']) }}"
                   class="relative mt-10 inline-flex h-14 items-center justify-center rounded-md bg-primary px-8 text-base font-medium text-on-primary transition hover:bg-primary-active">
                    Dapatkan Kabar Terbaru
                </a>
            </div>
        @endif
    </div>
</section>

{{-- ============ 07 · EKOSISTEM DAN MITRA ============ --}}
<section id="komunitas" class="scroll-mt-20 py-28 sm:py-36">
    <div class="container-app">
        <div class="flex flex-wrap items-end justify-between gap-6" data-reveal>
            <div class="max-w-2xl">
                <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">07 &middot; Ekosistem dan Mitra</span>
                <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-6xl">
                    7 komunitas partner aktif
                </h2>
                <p class="mt-6 text-xl leading-relaxed text-body">
                    Kami membuka ruang kolaborasi lintas kampus dan lintas komunitas. Klik tiap lingkaran untuk melihat profil mitra.
                </p>
            </div>
            <a href="{{ route('landing.whatsapp.redirect', ['source' => 'komunitas', 'campaign' => 'ajukan_kolaborasi']) }}"
               class="inline-flex h-12 shrink-0 items-center justify-center rounded-md border border-hairline px-6 text-sm font-medium text-ink transition hover:bg-surface-soft">
                Ajukan Kolaborasi
            </a>
        </div>

        {{-- Orbit layout — partner logos revolve around the MLUP mark like a galaxy --}}
        <div class="relative mx-auto mt-24 aspect-square w-full max-w-[380px] sm:max-w-[520px] lg:max-w-[620px]" data-reveal>
            <svg viewBox="0 0 100 100" class="absolute inset-0 h-full w-full text-hairline motion-safe:animate-[spin_70s_linear_infinite]">
                <circle cx="50" cy="50" r="41" fill="none" stroke="currentColor" stroke-width="0.4" stroke-dasharray="0.5 3" />
            </svg>
            <svg viewBox="0 0 100 100" class="absolute inset-0 h-full w-full text-hairline motion-safe:animate-[spin_100s_linear_infinite_reverse]">
                <circle cx="50" cy="50" r="22" fill="none" stroke="currentColor" stroke-width="0.4" stroke-dasharray="0.5 4" />
            </svg>

            <div class="absolute left-1/2 top-1/2 flex h-14 w-14 -translate-x-1/2 -translate-y-1/2 flex-col items-center justify-center gap-1 rounded-full bg-canvas p-2.5 shadow-xl sm:h-20 sm:w-20">
                <x-brand-mark class="h-full w-full" />
            </div>

            @php
                $partnerCount = max(count($partners), 1);
            @endphp
            @foreach ($partners as $index => $partner)
                @php
                    $angle = deg2rad(-90 + ($index * (360 / $partnerCount)));
                    $orbitX = 50 + 41 * cos($angle);
                    $orbitY = 50 + 41 * sin($angle);
                @endphp
                <a href="{{ route('landing.community.show', $partner['slug']) }}"
                   class="group absolute flex w-16 -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-2 sm:w-24 lg:w-28"
                   style="left: {{ $orbitX }}%; top: {{ $orbitY }}%;"
                   data-reveal data-reveal-delay="{{ min($index + 1, 5) }}">
                    <div class="relative h-11 w-11 overflow-hidden rounded-full bg-surface-card shadow-md ring-4 ring-canvas transition duration-300 group-hover:scale-110 group-hover:ring-primary sm:h-16 sm:w-16 lg:h-20 lg:w-20">
                        @if (!empty($partner['logo']['exists']))
                            <img src="{{ asset('images/partners/'.$partner['logo']['file']) }}" alt="{{ $partner['name'] }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center font-serif text-sm text-muted sm:text-xl">
                                {{ mb_substr($partner['name'], 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="text-center text-[10px] font-medium leading-snug text-body sm:text-xs lg:text-sm">{{ $partner['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ 08 · ROADMAP 1448 H ============ --}}
<section class="relative scroll-mt-20 overflow-hidden bg-surface-soft py-28 sm:py-36">
    <x-leaf class="pointer-events-none absolute -left-12 bottom-10 hidden h-64 w-64 -rotate-[12deg] text-ink/[0.04] xl:block" />

    <div class="container-app relative">
        <div class="max-w-2xl" data-reveal>
            <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">08 &middot; Roadmap 1448 H</span>
            <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-6xl">
                Beasiswa MLUP dan LINTAS
            </h2>
            <p class="mt-6 text-xl leading-relaxed text-body">Klik tiap titik untuk melihat detailnya.</p>
        </div>

        <div class="relative mt-24" x-data="accordionGroup(0)" data-reveal>
            <svg viewBox="0 0 1000 200" preserveAspectRatio="none" class="pointer-events-none absolute inset-x-0 top-[42px] hidden h-32 w-full text-muted-soft sm:block">
                <path d="M 80 40 Q 280 -30, 500 90 T 920 40" fill="none" stroke="currentColor" stroke-width="3.5" stroke-dasharray="0.5 12" stroke-linecap="round" opacity="0.6" />
            </svg>

            <div class="relative grid gap-12 sm:grid-cols-3 sm:gap-6">
                @foreach ($roadmap as $index => $milestone)
                    <button @click="toggle({{ $index }})" type="button" class="group flex flex-col items-center text-center {{ $index === 1 ? 'sm:mt-20' : '' }}">
                        <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full text-lg font-serif shadow-lg ring-4 ring-canvas transition group-hover:scale-105"
                              :class="isOpen({{ $index }}) ? 'bg-primary text-on-primary' : 'bg-surface-card text-ink'">
                            0{{ $index + 1 }}
                        </span>
                        <h3 class="mt-5 font-serif text-2xl text-ink">{{ $milestone['label'] }}</h3>
                        <div x-show="isOpen({{ $index }})" x-collapse x-cloak class="mt-3 max-w-[240px]">
                            <p class="text-sm leading-relaxed text-body">{{ $milestone['description'] }}</p>
                        </div>
                    </button>
                @endforeach

                <div class="flex flex-col items-center text-center">
                    <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full border-2 border-dashed border-hairline text-muted-soft">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 4v16m8-8H4" /></svg>
                    </span>
                    <h3 class="mt-5 font-serif text-2xl text-muted-soft">Segera Hadir</h3>
                    <p class="mt-3 max-w-[220px] text-sm leading-relaxed text-muted-soft">Roadmap terus bertumbuh mengikuti kebutuhan komunitas.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ 09 · SAYAP BARU ============ --}}
<section class="relative scroll-mt-20 overflow-hidden py-28 sm:py-36">
    <x-leaf class="pointer-events-none absolute -right-10 top-4 hidden h-56 w-56 rotate-[10deg] text-ink/[0.04] xl:block" />

    <div class="container-app relative">
        <div class="max-w-2xl" data-reveal>
            <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">09 &middot; Sayap Baru</span>
            <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-6xl">
                Literasi, Workshop, dan Online Course
            </h2>
        </div>

        <div class="mt-16 grid gap-6 sm:grid-cols-3">
            @foreach ($wings as $index => $wing)
                <div class="rounded-lg border border-hairline bg-canvas p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md" data-reveal data-reveal-delay="{{ min($index + 1, 5) }}">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-surface-card text-ink">
                        <x-icon :name="$wing['icon']" class="h-6 w-6" />
                    </span>
                    <h3 class="mt-6 font-serif text-2xl text-ink">{{ $wing['title'] }}</h3>
                    <p class="mt-3 text-base leading-relaxed text-body">{{ $wing['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ ARTIKEL & BERITA ============ --}}
@if ($latestArticles->isNotEmpty())
    <section class="bg-surface-soft py-28 sm:py-36">
        <div class="container-app">
            <div class="flex flex-wrap items-end justify-between gap-6" data-reveal>
                <div class="max-w-2xl">
                    <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Artikel &amp; Berita</span>
                    <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-6xl">
                        Kabar kegiatan MLUP Academy
                    </h2>
                </div>
                <a href="{{ route('articles.index') }}" class="inline-flex h-12 shrink-0 items-center justify-center rounded-md border border-hairline px-6 text-sm font-medium text-ink transition hover:bg-canvas">
                    Lihat Semua Artikel
                </a>
            </div>

            <div class="mt-16 grid gap-6 sm:grid-cols-3">
                @foreach ($latestArticles as $index => $article)
                    <a href="{{ route('articles.show', $article) }}"
                       class="group flex flex-col overflow-hidden rounded-lg border border-hairline bg-canvas shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
                       data-reveal data-reveal-delay="{{ min($index + 1, 5) }}">
                        <div class="relative aspect-[16/10] overflow-hidden bg-surface-card">
                            @if ($article->cover_image)
                                <img src="{{ asset('images/articles/'.$article->cover_image) }}" alt="{{ $article->title }}" loading="lazy" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                            @else
                                <div class="photo-frame absolute inset-0 text-ink/[0.06]"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <x-brand-mark class="h-10 w-10 opacity-60" />
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <p class="text-xs font-medium uppercase tracking-[0.1em] text-muted">{{ $article->published_at->translatedFormat('d F Y') }}</p>
                            <h3 class="mt-3 font-serif text-xl text-ink">{{ $article->title }}</h3>
                            @if ($article->excerpt)
                                <p class="mt-2 flex-1 text-sm leading-relaxed text-body">{{ $article->excerpt }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- ============ KONTAK ============ --}}
<section id="kontak" class="relative scroll-mt-20 overflow-hidden py-28 sm:py-36">
    <x-leaf class="pointer-events-none absolute -right-10 top-16 hidden h-60 w-60 rotate-[22deg] text-ink/[0.04] lg:block" />

    <div class="container-app relative">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
            <div data-reveal>
                <span class="text-sm font-medium uppercase tracking-[0.15em] text-primary">Kontak</span>
                <h2 class="mt-6 font-serif text-4xl leading-tight tracking-tight text-ink text-balance sm:text-6xl">
                    Kami siap terhubung dengan Anda
                </h2>
                <p class="mt-6 max-w-lg text-xl leading-relaxed text-body">
                    Punya pertanyaan, ingin berkolaborasi, atau sekadar menyapa? Hubungi kami lewat kanal berikut.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2" data-reveal data-reveal-delay="1">
                <div class="rounded-lg border border-hairline bg-canvas p-6 shadow-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-surface-card text-primary">
                        <x-icon name="map-pin" class="h-5 w-5" />
                    </span>
                    <h3 class="mt-4 text-xs font-medium uppercase tracking-[0.1em] text-muted">Lokasi</h3>
                    <p class="mt-1 text-lg text-ink">Bandung, Jawa Barat</p>
                </div>

                <a href="{{ route('landing.whatsapp.redirect', ['source' => 'kontak', 'campaign' => 'gabung_komunitas']) }}"
                   class="group rounded-lg border border-hairline bg-canvas p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-primary text-on-primary">
                        <x-icon name="chat" class="h-5 w-5" />
                    </span>
                    <h3 class="mt-4 text-xs font-medium uppercase tracking-[0.1em] text-muted">WhatsApp</h3>
                    <p class="mt-1 flex items-center gap-1 text-lg text-ink">
                        Chat Sekarang
                        <x-icon name="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1" />
                    </p>
                </a>

                <div class="rounded-lg border border-hairline bg-canvas p-6 shadow-sm sm:col-span-2">
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-surface-card text-primary">
                        <x-icon name="globe" class="h-5 w-5" />
                    </span>
                    <h3 class="mt-4 text-xs font-medium uppercase tracking-[0.1em] text-muted">Jangkauan</h3>
                    <p class="mt-1 text-lg text-ink">Seluruh Indonesia</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ 10 · KOLABORASI ============ --}}
<section class="py-28 sm:py-36">
    <div class="container-app">
        <div class="relative overflow-hidden rounded-2xl bg-primary px-8 py-24 text-center sm:px-20" data-reveal>
            <div class="pattern-lattice absolute inset-0 text-on-primary/10"></div>
            <x-leaf class="pointer-events-none absolute -left-8 -top-10 hidden h-56 w-56 -rotate-[15deg] text-on-primary/10 md:block" />
            <x-leaf class="pointer-events-none absolute -right-10 -bottom-14 hidden h-64 w-64 rotate-[20deg] text-on-primary/10 md:block" />
            <div class="relative">
                <span class="text-sm font-medium uppercase tracking-[0.15em] text-on-primary/70">10 &middot; Kolaborasi</span>
                <h2 class="mx-auto mt-6 max-w-2xl font-serif text-4xl leading-tight tracking-tight text-on-primary text-balance sm:text-6xl">
                    Mari bergabung bersama kami
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-xl text-on-primary/85">
                    Baik sebagai pelajar, mahasiswa, profesional muda, maupun donatur — ada ruang untuk Anda berkontribusi.
                </p>
                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('landing.whatsapp.redirect', ['source' => 'cta_final', 'campaign' => 'gabung_komunitas']) }}"
                       class="inline-flex h-14 items-center justify-center rounded-md bg-canvas px-8 text-base font-medium text-ink transition hover:bg-surface-soft">
                        Gabung Komunitas
                    </a>
                    <a href="{{ route('landing.whatsapp.redirect', ['source' => 'cta_final', 'campaign' => 'jadi_donatur']) }}"
                       class="inline-flex h-14 items-center justify-center rounded-md border border-on-primary/40 px-8 text-base font-medium text-on-primary transition hover:bg-primary-active">
                        Jadi Donatur
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
