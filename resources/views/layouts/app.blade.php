<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MLUP Academy' }}</title>
    <style>
        :root {
            --bg: #f5f1e8;
            --panel: #fffdf8;
            --text: #1b1c1d;
            --muted: #5f6470;
            --line: #ddd2be;
            --brand: #125d38;
            --brand-soft: #d8ecd9;
            --accent: #c46b2d;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--text);
            background:
                radial-gradient(circle at top right, rgba(196,107,45,.12), transparent 30%),
                linear-gradient(180deg, #f6f2e8 0%, #efe6d5 100%);
        }
        a { color: inherit; }
        .container { width: min(1160px, calc(100% - 32px)); margin: 0 auto; }
        .nav { padding: 20px 0; display: flex; justify-content: space-between; align-items: center; gap: 12px; }
        .nav a { text-decoration: none; }
        .badge {
            display: inline-flex;
            border-radius: 999px;
            padding: 6px 12px;
            background: var(--brand-soft);
            color: var(--brand);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 20px;
            box-shadow: 0 18px 50px rgba(49, 45, 35, .08);
        }
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 18px;
            border-radius: 14px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 15px;
            font-weight: 700;
        }
        .button-primary { background: var(--brand); color: #fff; }
        .button-secondary { background: transparent; color: var(--text); border: 1px solid var(--line); }
        .grid { display: grid; gap: 20px; }
        .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .metric { padding: 22px; }
        .metric strong { display: block; font-size: 32px; margin-top: 10px; }
        .muted { color: var(--muted); }
        .section { padding: 24px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 12px; border-bottom: 1px solid var(--line); text-align: left; vertical-align: top; }
        .table th { font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); }
        .pill { display: inline-flex; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; background: #eee5d2; }
        .stack { display: grid; gap: 14px; }
        .hero { padding: 56px 0 30px; }
        .hero-box { padding: 36px; }
        .hero h1 { font-size: clamp(38px, 6vw, 72px); line-height: 0.96; margin: 18px 0; max-width: 720px; }
        .hero p { font-size: 18px; line-height: 1.7; max-width: 680px; color: var(--muted); }
        .mini { font-size: 13px; color: var(--muted); }
        .filters { display: flex; gap: 12px; flex-wrap: wrap; }
        .filters input, .filters select, .filters textarea { width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid var(--line); background: #fff; }
        .detail-list { display: grid; gap: 10px; }
        .detail-list div { padding: 12px; background: #fbf7ef; border-radius: 12px; }
        @media (max-width: 900px) {
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .hero-box { padding: 24px; }
            .hero h1 { font-size: 42px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="{{ route('landing.index') }}"><strong>MLUP Academy</strong></a>
            <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                <a href="{{ route('landing.whatsapp.redirect', ['source' => 'navbar', 'campaign' => 'header']) }}" class="button button-secondary">Chat WhatsApp</a>
                @auth
                    <a href="{{ route('hotline.dashboard') }}" class="button button-secondary">Dashboard</a>
                    <a href="{{ route('admin.articles.index') }}" class="button button-primary">Artikel</a>
                    <form method="post" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="button button-secondary">Logout</button>
                    </form>
                @else
                    <a href="{{ route('admin.login') }}" class="button button-primary">Login Admin</a>
                @endauth
            </div>
        </div>
    </div>

    @yield('content')
</body>
</html>
