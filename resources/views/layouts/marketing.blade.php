<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $metaTitle = $title ?? 'MLUP Academy — Unggul dalam Ilmu, Kuat dalam Iman';
        $metaDescription = $description ?? 'MLUP (Muslim Level Up) Academy — komunitas pendidikan muslim Indonesia yang mempertemukan keunggulan akademik dengan kekuatan keislaman.';
    @endphp
    <meta name="description" content="{{ $metaDescription }}">
    <title>{{ $metaTitle }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/brand/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/brand/logo.png') }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="MLUP Academy">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ asset('images/brand/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ asset('images/brand/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas text-body font-sans antialiased">

    <div id="scroll-progress" class="fixed inset-x-0 top-0 z-[60] h-[3px] origin-left scale-x-0 bg-primary"></div>

    <header x-data="siteNav()" class="sticky top-0 z-50 border-b transition-colors duration-300"
            :class="scrolled ? 'bg-canvas/90 backdrop-blur border-hairline' : 'bg-canvas/0 border-transparent'">
        <div class="container-app flex h-16 items-center justify-between md:h-[72px]">
            <a href="{{ route('landing.index') }}" class="flex items-center gap-2.5">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-canvas ring-1 ring-hairline">
                    <x-brand-mark class="h-6 w-6" />
                </span>
                <span class="font-serif text-lg font-medium tracking-tight text-ink">MLUP <span class="italic">Academy</span></span>
            </a>

            <nav class="hidden items-center gap-8 lg:flex">
                <a href="#tentang" class="text-sm font-medium text-body transition hover:text-ink">Tentang Kami</a>
                <a href="#visi-misi" class="text-sm font-medium text-body transition hover:text-ink">Visi &amp; Misi</a>
                <a href="#nilai" class="text-sm font-medium text-body transition hover:text-ink">Nilai Kami</a>
                <a href="#komunitas" class="text-sm font-medium text-body transition hover:text-ink">Komunitas</a>
                <a href="#program" class="text-sm font-medium text-body transition hover:text-ink">Program</a>
                <a href="{{ route('articles.index') }}" class="text-sm font-medium text-body transition hover:text-ink">Artikel</a>
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                @auth
                    <a href="{{ route('hotline.dashboard') }}" class="text-sm font-medium text-body transition hover:text-ink">Dashboard</a>
                @else
                    <a href="{{ route('admin.login') }}" class="text-sm font-medium text-body transition hover:text-ink">Login Admin</a>
                @endauth
                <a href="{{ route('landing.whatsapp.redirect', ['source' => 'navbar', 'campaign' => 'gabung_komunitas']) }}"
                   class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-5 text-sm font-medium text-on-primary shadow-sm transition hover:bg-primary-active">
                    Gabung Komunitas
                </a>
            </div>

            <button @click="open = !open" class="flex h-10 w-10 items-center justify-center rounded-md border border-hairline text-ink lg:hidden" aria-label="Buka menu">
                <svg x-show="!open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" /></svg>
                <svg x-show="open" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div x-show="open" x-cloak x-transition @click.outside="close()" class="border-t border-hairline bg-canvas px-5 pb-6 pt-2 lg:hidden">
            <nav class="flex flex-col gap-1 py-2">
                <a @click="close()" href="#tentang" class="rounded-md px-3 py-2.5 text-sm font-medium text-body hover:bg-surface-soft hover:text-ink">Tentang Kami</a>
                <a @click="close()" href="#visi-misi" class="rounded-md px-3 py-2.5 text-sm font-medium text-body hover:bg-surface-soft hover:text-ink">Visi &amp; Misi</a>
                <a @click="close()" href="#nilai" class="rounded-md px-3 py-2.5 text-sm font-medium text-body hover:bg-surface-soft hover:text-ink">Nilai Kami</a>
                <a @click="close()" href="#komunitas" class="rounded-md px-3 py-2.5 text-sm font-medium text-body hover:bg-surface-soft hover:text-ink">Komunitas</a>
                <a @click="close()" href="#program" class="rounded-md px-3 py-2.5 text-sm font-medium text-body hover:bg-surface-soft hover:text-ink">Program</a>
                <a @click="close()" href="{{ route('articles.index') }}" class="rounded-md px-3 py-2.5 text-sm font-medium text-body hover:bg-surface-soft hover:text-ink">Artikel</a>
                @auth
                    <a @click="close()" href="{{ route('hotline.dashboard') }}" class="rounded-md px-3 py-2.5 text-sm font-medium text-body hover:bg-surface-soft hover:text-ink">Dashboard</a>
                @else
                    <a @click="close()" href="{{ route('admin.login') }}" class="rounded-md px-3 py-2.5 text-sm font-medium text-body hover:bg-surface-soft hover:text-ink">Login Admin</a>
                @endauth
            </nav>
            <a href="{{ route('landing.whatsapp.redirect', ['source' => 'navbar_mobile', 'campaign' => 'gabung_komunitas']) }}"
               class="mt-2 flex h-11 items-center justify-center rounded-md bg-primary px-5 text-sm font-medium text-on-primary">
                Gabung Komunitas
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="relative overflow-hidden bg-surface-dark py-16 text-on-dark-soft">
        <div class="container-app">
            <div class="grid gap-12 lg:grid-cols-[1.3fr_0.9fr_0.9fr_1fr]">
                <div>
                    <a href="{{ route('landing.index') }}" class="flex items-center gap-2.5">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-on-dark">
                            <x-brand-mark class="h-6 w-6" />
                        </span>
                        <span class="font-serif text-lg font-medium tracking-tight text-on-dark">MLUP <span class="italic">Academy</span></span>
                    </a>
                    <p class="mt-4 max-w-xs text-sm leading-relaxed">
                        Komunitas pendidikan bagi pelajar dan mahasiswa muslim Indonesia — mempertemukan keunggulan akademik dan kekuatan keislaman dalam satu ekosistem.
                    </p>
                    <p class="mt-6 text-xs uppercase tracking-[0.15em] text-on-dark-soft/70">Berdiri 23 Desember 2025 &middot; Berbasis di Bandung</p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.15em] text-on-dark/60">Jelajahi</p>
                    <nav class="mt-4 flex flex-col gap-3 text-sm">
                        <a href="#tentang" class="transition hover:text-on-dark">Tentang Kami</a>
                        <a href="#visi-misi" class="transition hover:text-on-dark">Visi &amp; Misi</a>
                        <a href="#nilai" class="transition hover:text-on-dark">Nilai Kami</a>
                        <a href="#program" class="transition hover:text-on-dark">Program</a>
                    </nav>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.15em] text-on-dark/60">Organisasi</p>
                    <nav class="mt-4 flex flex-col gap-3 text-sm">
                        <a href="#komunitas" class="transition hover:text-on-dark">Ekosistem &amp; Mitra</a>
                        @auth
                            <a href="{{ route('hotline.dashboard') }}" class="transition hover:text-on-dark">Dashboard Admin</a>
                        @else
                            <a href="{{ route('admin.login') }}" class="transition hover:text-on-dark">Login Admin</a>
                        @endauth
                    </nav>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.15em] text-on-dark/60">Terhubung</p>
                    <p class="mt-4 text-sm leading-relaxed">Punya pertanyaan atau ingin berkolaborasi? Sapa kami lewat WhatsApp.</p>
                    <a href="{{ route('landing.whatsapp.redirect', ['source' => 'footer', 'campaign' => 'gabung_komunitas']) }}"
                       class="mt-4 inline-flex h-10 items-center justify-center rounded-md bg-surface-dark-elevated px-5 text-sm font-medium text-on-dark transition hover:bg-surface-dark-soft">
                        Chat WhatsApp
                    </a>
                </div>
            </div>

            <div class="relative mt-16 overflow-hidden" aria-hidden="true">
                <p class="select-none whitespace-nowrap text-center font-sans font-bold leading-[0.85] tracking-tighter text-on-dark/[0.07]" style="font-size: clamp(3rem, 15vw, 11rem);">
                    LEVEL UP
                </p>
            </div>

            <div class="mt-10 flex flex-col gap-3 border-t border-white/10 pt-8 text-xs text-on-dark-soft/70 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ date('Y') }} MLUP (Muslim Level Up) Academy. Seluruh hak cipta dilindungi.</p>
                <p>Unggul dalam Ilmu &middot; Kuat dalam Iman</p>
            </div>
        </div>
    </footer>
</body>
</html>
