<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $metaTitle = $title ?? 'MLUP Academy';
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,500;1,9..144,300;1,9..144,400&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* ─── DESIGN TOKENS (mirroring MLUP system) ─── */
    :root {
      --font-serif: 'Fraunces', 'Times New Roman', serif;
      --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;

      --color-primary: #c2793a;
      --color-primary-active: #9c5f2b;
      --color-ink: #23261f;
      --color-body: #40453b;
      --color-muted: #666b5d;
      --color-muted-soft: #8d9284;
      --color-hairline: #e0e2d8;
      --color-canvas: #f8f8f4;
      --color-surface-soft: #f0f1ea;
      --color-surface-card: #e7e9de;
      --color-surface-dark: #20291f;
      --color-surface-dark-elevated: #2b3729;
      --color-on-primary: #fffaf3;
      --color-on-dark: #f2f4ec;
      --color-on-dark-soft: #aab5a0;
      --color-accent-teal: #5f8a52;
      --color-accent-amber: #d1a13a;
      --color-accent-blue: #3f728f;

      --radius-md: 8px;
      --radius-lg: 12px;
      --radius-xl: 16px;
      --radius-2xl: 24px;
      --radius-pill: 9999px;
    }

    /* ─── SCROLL PROGRESS ─── */
    #scroll-progress {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: var(--color-primary);
      transform-origin: left;
      transform: scaleX(0);
      z-index: 100;
      transition: transform 0.05s linear;
    }

    /* ─── NAVBAR ─── */
    .navbar {
      position: sticky;
      top: 0;
      z-index: 50;
      background: rgba(248, 248, 244, 0.92);
      backdrop-filter: blur(8px);
      border-bottom: 1px solid var(--color-hairline);
    }
    .navbar-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 68px;
    }
    .navbar-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }
    .navbar-brand-logo {
      width: 36px;
      height: 36px;
      object-fit: contain;
      display: block;
    }
    .navbar-brand-text {
      font-family: var(--font-serif);
      font-size: 17px;
      color: var(--color-ink);
      font-weight: 400;
    }
    .navbar-brand-text em {
      font-style: italic;
      color: var(--color-primary);
    }
    .navbar-links {
      display: flex;
      align-items: center;
      gap: 32px;
      list-style: none;
    }
    .navbar-links a {
      font-size: 14px;
      font-weight: 500;
      color: var(--color-muted);
      text-decoration: none;
      transition: color 0.15s;
    }
    .navbar-links a:hover { color: var(--color-ink); }
    .navbar-cta {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      height: 40px;
      padding: 0 20px;
      border-radius: var(--radius-md);
      background: var(--color-primary);
      color: var(--color-on-primary);
      font-size: 14px;
      font-weight: 500;
      text-decoration: none;
      transition: background 0.15s, transform 0.2s;
    }
    .navbar-cta:hover {
      background: var(--color-primary-active);
      transform: translateY(-1px);
    }
    .navbar-mobile-btn {
      display: none;
      background: none;
      border: 1px solid var(--color-hairline);
      border-radius: var(--radius-md);
      width: 40px; height: 40px;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      color: var(--color-ink);
    }

    /* ─── FOOTER ─── */
    .footer {
      background: var(--color-ink);
      padding: 40px 0;
    }
    .footer-inner {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
    }
    .footer-brand {
      font-family: var(--font-serif);
      font-size: 16px;
      color: rgba(242,244,236,0.6);
    }
    .footer-brand em { font-style: italic; color: var(--color-primary); }
    .footer-back {
      font-size: 13px;
      color: rgba(170,181,160,0.6);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: color 0.15s;
    }
    .footer-back:hover { color: var(--color-on-dark); }
    .footer-note {
      font-size: 12px;
      color: rgba(170,181,160,0.35);
      text-align: center;
      width: 100%;
      padding-top: 24px;
      border-top: 1px solid rgba(255,255,255,0.05);
      margin-top: 16px;
    }

    /* ─── MOBILE ─── */
    @media (max-width: 768px) {
      .navbar-links, .navbar-cta-wrap { display: none; }
      .navbar-mobile-btn { display: flex; }
      
      /* Dropdown styles for mobile links when active */
      .navbar-links.open {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 68px;
        left: 0;
        right: 0;
        background: rgba(248, 248, 244, 0.98);
        border-bottom: 1px solid var(--color-hairline);
        padding: 20px;
        gap: 16px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
      }
    }
    </style>
</head>
<body class="bg-canvas text-body font-sans antialiased">

    <div id="scroll-progress"></div>

    <!-- ══════════ NAVBAR ══════════ -->
    <header class="navbar">
      <div class="container-app navbar-inner">
        <a href="{{ route('landing.index') }}" class="navbar-brand">
          <img src="{{ asset('images/brand/logo.png') }}" alt="MLUP Logo" class="navbar-brand-logo">
          <span class="navbar-brand-text">MLUP <em>Academy</em></span>
        </a>

        <ul class="navbar-links">
          <li><a href="{{ route('landing.index') }}#masalah">Yang Dicover</a></li>
          <li><a href="{{ route('landing.index') }}#fasilitator">Fasilitator</a></li>
          <li><a href="{{ route('landing.index') }}#alur">Cara Kerja</a></li>
          <li><a href="{{ route('landing.index') }}#cerita">Cerita</a></li>
        </ul>

        <div class="navbar-cta-wrap">
          <a href="{{ route('landing.index') }}#hubungi" class="navbar-cta">Hubungi Sekarang</a>
        </div>

        <button class="navbar-mobile-btn" aria-label="Menu">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- ══════════ FOOTER ══════════ -->
    <footer class="footer">
      <div class="container-app">
        <div class="footer-inner">
          <span class="footer-brand">MLUP <em>Academy</em> — Hotline Akademik</span>
          
          <div style="display: flex; flex-wrap: wrap; gap: 24px; align-items: center;">
            <a href="{{ route('articles.index') }}" class="footer-back" style="color: rgba(170,181,160,0.6); text-decoration: none; font-size: 13.5px; transition: color 0.15s;">Artikel</a>
            @auth
              <a href="{{ route('hotline.dashboard') }}" class="footer-back" style="color: rgba(170,181,160,0.6); text-decoration: none; font-size: 13.5px; transition: color 0.15s;">Dashboard Admin</a>
            @else
              <a href="{{ route('admin.login') }}" class="footer-back" style="color: rgba(170,181,160,0.6); text-decoration: none; font-size: 13.5px; transition: color 0.15s;">Login Admin</a>
            @endauth
            <a href="https://mlup.konekin.space/" class="footer-back">
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7"/></svg>
              Kembali ke MLUP Academy
            </a>
          </div>
        </div>
        <p class="footer-note">
          © {{ date('Y') }} · MLUP Academy · Bandung, Jawa Barat, Indonesia — Komunitas pendidikan muslim Indonesia.
        </p>
      </div>
    </footer>

    <script>
    // ── Scroll Progress ──
    const progressBar = document.getElementById('scroll-progress');
    window.addEventListener('scroll', () => {
      const max = document.documentElement.scrollHeight - window.innerHeight;
      const pct = max > 0 ? window.scrollY / max : 0;
      progressBar.style.transform = `scaleX(${pct})`;
    }, { passive: true });

    // ── Mobile Menu Toggle ──
    const mobileBtn = document.querySelector('.navbar-mobile-btn');
    const navLinks = document.querySelector('.navbar-links');
    if (mobileBtn && navLinks) {
      mobileBtn.addEventListener('click', () => {
        navLinks.classList.toggle('open');
      });
      navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
          navLinks.classList.remove('open');
        });
      });
    }
    </script>
</body>
</html>
