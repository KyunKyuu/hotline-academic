<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Pusat Kendali - MLUP Academy' }}</title>
    <style>
        :root {
            --canvas: #010102;
            --surface-1: #0f1011;
            --surface-2: #141516;
            --surface-3: #18191a;
            --surface-4: #191a1b;
            
            --ink: #f7f8f8;
            --ink-muted: #d0d6e0;
            --ink-subtle: #8a8f98;
            --ink-tertiary: #62666d;
            
            --primary: #5e6ad2; /* Lavender Blue */
            --on-primary: #ffffff;
            --primary-hover: #828fff;
            --primary-focus: #5e69d1;
            --primary-glow: rgba(94, 106, 210, 0.15);
            
            --hairline: #23252a;
            --hairline-strong: #34343a;
            --hairline-tertiary: #3e3e44;
            
            --semantic-success: #27a644;
            --semantic-error: #cf2d56;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--canvas);
            color: var(--ink);
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            letter-spacing: -0.05px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* Layout wrapper */
        .admin-shell {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar styling - dense, technical, quietly luxurious */
        .sidebar {
            width: 270px;
            background-color: var(--surface-1);
            border-right: 1px solid var(--hairline);
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 36px;
            padding-left: 8px;
        }

        .brand-text {
            font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: -0.6px;
            color: var(--ink);
        }

        .brand-text span {
            color: var(--primary);
        }

        .nav-section {
            margin-bottom: 28px;
        }

        .nav-section-title {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--ink-subtle);
            margin-bottom: 10px;
            padding-left: 8px;
        }

        .nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 400;
            color: var(--ink-muted);
            border-radius: 6px;
            transition: background 0.15s, color 0.15s;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.04);
            color: var(--ink);
        }

        .nav-link.active {
            background-color: var(--surface-2);
            color: var(--ink);
            font-weight: 500;
            border-left: 2px solid var(--primary);
            padding-left: 10px;
        }

        /* Sidebar footer user area */
        .sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--hairline);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .user-info {
            padding-left: 8px;
        }

        .user-name {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
            display: block;
        }

        .user-email {
            font-size: 12px;
            color: var(--ink-subtle);
            display: block;
        }

        /* Content Area */
        .main-content {
            flex: 1;
            padding: 48px 56px;
            overflow-y: auto;
        }

        /* Shared Dashboard Elements following DESIGN-linear.app(1).md */
        .badge {
            display: inline-flex;
            border-radius: 9999px;
            padding: 2px 8px;
            background-color: var(--surface-2);
            color: var(--ink-muted);
            border: 1px solid var(--hairline);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .h1-display {
            font-size: 32px;
            font-weight: 600;
            letter-spacing: -1.0px;
            line-height: 1.15;
            color: var(--ink);
            margin-top: 12px;
            margin-bottom: 24px;
        }

        .card {
            background: var(--surface-1);
            border: 1px solid var(--hairline);
            border-radius: 12px; /* rounded-lg */
            box-shadow: none; /* No shadow according to Linear philosophy */
        }

        .section {
            padding: 24px;
            margin-bottom: 24px;
        }

        .stack {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Buttons matching Linear design */
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 14px;
            height: 36px;
            border-radius: 8px; /* rounded-md */
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: background 0.15s, transform 0.1s;
        }

        .button:active {
            transform: scale(0.98);
        }

        .button-primary {
            background-color: var(--primary);
            color: var(--on-primary);
        }

        .button-primary:hover {
            background-color: var(--primary-hover);
        }

        .button-secondary {
            background-color: var(--surface-2);
            color: var(--ink);
            border: 1px solid var(--hairline-strong);
        }

        .button-secondary:hover {
            background-color: var(--surface-3);
            border-color: var(--hairline-tertiary);
        }

        .button-danger {
            background-color: var(--semantic-error);
            color: #ffffff;
        }

        /* Tables matching minimal clean hairline style */
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table th, .table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--hairline);
            text-align: left;
            vertical-align: middle;
        }

        .table th {
            background-color: var(--surface-2);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            color: var(--ink-subtle);
            border-top: 1px solid var(--hairline);
        }

        .table td {
            color: var(--ink-muted);
        }

        .table tr:hover td {
            background-color: var(--surface-2);
            color: var(--ink);
        }

        .pill {
            display: inline-flex;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
            background-color: var(--surface-2);
            color: var(--ink-muted);
            border: 1px solid var(--hairline);
        }

        .grid {
            display: grid;
            gap: 24px;
        }

        .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .metric {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            background-color: var(--surface-1);
        }

        .metric .muted {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            color: var(--ink-subtle);
        }

        .metric strong {
            font-size: 32px;
            font-weight: 600;
            letter-spacing: -1.0px;
            color: var(--ink);
        }

        .mini {
            font-size: 12px;
            color: var(--ink-subtle);
        }

        /* Form Inputs */
        .filters {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        input[type="text"], input[type="email"], input[type="password"], input[type="number"], select, textarea {
            width: 100%;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid var(--hairline-strong);
            background-color: var(--surface-1);
            color: var(--ink);
            font-size: 14px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--primary-focus);
            box-shadow: 0 0 0 2px var(--primary-glow);
        }

        label {
            font-size: 13px;
            font-weight: 500;
            color: var(--ink-muted);
            margin-bottom: 6px;
            display: block;
        }

        code, pre {
            font-family: 'Linear Mono', 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 13px;
            color: #d0d6e0;
        }

        @media (max-width: 900px) {
            .admin-shell {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--hairline);
            }
            .grid-2, .grid-3 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="sidebar">
            <div class="brand-area">
                <x-brand-mark style="width: 24px; height: 24px; color: var(--primary);" />
                <span class="brand-text">MLUP <span>Admin</span></span>
            </div>

            {{-- Sidebar Navigation with Submenus --}}
            <nav class="nav-section">
                <h3 class="nav-section-title">Hotline Chatbot</h3>
                <ul class="nav-list">
                    <li>
                        <a href="{{ route('hotline.dashboard') }}" class="nav-link {{ request()->routeIs('hotline.dashboard*') ? 'active' : '' }}">
                            Dashboard
                        </a>
                    </li>
                </ul>
            </nav>

            <nav class="nav-section">
                <h3 class="nav-section-title">Artikel</h3>
                <ul class="nav-list">
                    <li>
                        <a href="{{ route('admin.articles.index') }}" class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                            Kelola Artikel
                        </a>
                    </li>
                </ul>
            </nav>

            <nav class="nav-section">
                <h3 class="nav-section-title">Landing Page</h3>
                <ul class="nav-list">
                    <li>
                        <a href="{{ route('admin.landing.index') }}" class="nav-link {{ request()->routeIs('admin.landing.index') ? 'active' : '' }}">
                            Hero Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.landing.moments.index') }}" class="nav-link {{ request()->routeIs('admin.landing.moments.*') ? 'active' : '' }}">
                            Momen Kegiatan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.landing.partners.index') }}" class="nav-link {{ request()->routeIs('admin.landing.partners.*') ? 'active' : '' }}">
                            Partner Komunitas
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                @auth
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-email">{{ Auth::user()->email }}</span>
                    </div>
                    <form method="post" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="button button-secondary" style="width: 100%; height: 36px; padding: 0;">Logout</button>
                    </form>
                @endauth
            </div>
        </aside>

        <main class="main-content">
            @yield('content')
        </main>
    </div>
</body>
</html>
