<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - MLUP Academy</title>
    <style>
        :root {
            --bg: #efe6d5;
            --panel: rgba(255, 253, 248, 0.85);
            --panel-strong: rgba(255, 255, 255, 0.95);
            --text: #1b1c1d;
            --muted: #5f6470;
            --line: #ddd2be;
            --line-strong: #c4b9a3;
            --accent: #125d38; /* brand primary */
            --accent-strong: #0a3d24;
            --accent-soft: #d8ecd9;
            --accent-orange: #c46b2d;
            --danger-bg: #fce8e6;
            --danger-line: #fad2cf;
            --danger-text: #c5221f;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100dvh;
            color: var(--text);
            font-family: "Georgia", "Times New Roman", serif;
            background:
                radial-gradient(circle at 18% 18%, rgba(18, 93, 56, .08), transparent 26%),
                radial-gradient(circle at 78% 8%, rgba(196, 107, 45, .06), transparent 22%),
                linear-gradient(180deg, #f6f2e8 0%, var(--bg) 100%);
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(18, 93, 56, .015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(18, 93, 56, .015) 1px, transparent 1px);
            background-size: 72px 72px;
            mask-image: radial-gradient(circle at center, black 0%, transparent 72%);
        }

        body::after {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(120deg, transparent 0%, rgba(18, 93, 56, .01) 45%, transparent 58%);
            animation: sheen 8s ease-in-out infinite;
            opacity: .55;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input {
            font: inherit;
        }

        .login-shell {
            position: relative;
            min-height: 100dvh;
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(360px, .72fr);
            gap: 56px;
            align-items: center;
            padding: 38px 0;
        }

        .topbar {
            position: absolute;
            top: 24px;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--text);
            font-weight: 700;
            letter-spacing: -.02em;
        }

        .brand-mark {
            width: 32px;
            height: 32px;
            border: 1px solid var(--line-strong);
            border-radius: 10px;
            display: grid;
            place-items: center;
            background: var(--accent-soft);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .4);
            color: var(--accent);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 9px 13px;
            background: rgba(255, 255, 255, .5);
            transition: transform .24s cubic-bezier(.16, 1, .3, 1), border-color .24s ease, color .24s ease;
        }

        .back-link:hover {
            color: var(--text);
            border-color: var(--line-strong);
            transform: translateY(-1px);
        }

        .hero-copy {
            padding-top: 72px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--accent);
            border: 1px solid var(--accent-soft);
            background: var(--accent-soft);
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 99px;
            background: var(--accent-orange);
            box-shadow: 0 0 0 5px rgba(196, 107, 45, .15);
            animation: breathe 2.6s ease-in-out infinite;
        }

        h1 {
            max-width: 690px;
            margin: 22px 0 18px;
            font-size: clamp(42px, 6vw, 76px);
            line-height: .92;
            letter-spacing: -.05em;
            font-family: "Georgia", "Times New Roman", serif;
            font-weight: normal;
        }

        .hero-copy p {
            max-width: 560px;
            margin: 0;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.75;
            font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
        }

        .signal-grid {
            display: grid;
            grid-template-columns: 1.1fr .8fr;
            gap: 14px;
            max-width: 590px;
            margin-top: 42px;
            font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
        }

        .signal-card {
            border: 1px solid var(--line);
            border-radius: 22px;
            padding: 18px;
            background: rgba(255, 253, 248, .6);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .8);
        }

        .signal-card.wide {
            grid-column: 1 / -1;
        }

        .signal-label {
            color: var(--muted);
            font-size: 12px;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .signal-value {
            display: block;
            margin-top: 10px;
            color: var(--accent);
            font-size: 24px;
            font-weight: 750;
            letter-spacing: -.04em;
        }

        .signal-text {
            margin-top: 10px;
            color: var(--muted);
            line-height: 1.55;
            font-size: 14px;
        }

        .login-panel {
            position: relative;
            border: 1px solid var(--line-strong);
            border-radius: 28px;
            padding: 1px;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .6), rgba(255, 255, 255, .2) 34%, rgba(18, 93, 56, .15));
            box-shadow: 0 28px 80px rgba(49, 45, 35, 0.08);
            font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
        }

        .login-card {
            border-radius: 27px;
            padding: 30px;
            background: var(--panel);
            backdrop-filter: blur(22px);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .6);
        }

        .panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 26px;
        }

        .panel-header h2 {
            margin: 0 0 8px;
            font-size: 26px;
            letter-spacing: -.045em;
            font-family: "Georgia", "Times New Roman", serif;
            font-weight: normal;
        }

        .panel-header p {
            margin: 0;
            color: var(--muted);
            line-height: 1.55;
            font-size: 14px;
        }

        .secure-pill {
            flex: 0 0 auto;
            color: var(--accent);
            border: 1px solid var(--line-strong);
            border-radius: 999px;
            padding: 8px 10px;
            background: var(--accent-soft);
            font-size: 12px;
            font-weight: 700;
        }

        .error-box {
            margin-bottom: 18px;
            border: 1px solid var(--danger-line);
            border-radius: 16px;
            padding: 13px 14px;
            background: var(--danger-bg);
            color: var(--danger-text);
            line-height: 1.45;
            font-size: 14px;
        }

        .form-stack {
            display: grid;
            gap: 16px;
        }

        .field {
            display: grid;
            gap: 8px;
        }

        .field label {
            color: var(--text);
            font-size: 13px;
            font-weight: 700;
        }

        .field input[type="email"],
        .field input[type="password"] {
            width: 100%;
            min-height: 50px;
            border: 1px solid var(--line);
            border-radius: 15px;
            color: var(--text);
            background: #ffffff;
            padding: 0 15px;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .field input::placeholder {
            color: #8890a0;
        }

        .field input:focus {
            border-color: var(--accent);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(18, 93, 56, .12);
        }

        .helper {
            color: var(--muted);
            font-size: 12px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            color: var(--muted);
            font-size: 13px;
        }

        .check-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .check-label input {
            width: 16px;
            height: 16px;
            accent-color: var(--accent);
        }

        .submit-button {
            width: 100%;
            min-height: 52px;
            border: 0;
            border-radius: 16px;
            color: #ffffff;
            background: linear-gradient(180deg, var(--accent) 0%, var(--accent-strong) 100%);
            cursor: pointer;
            font-weight: 800;
            letter-spacing: -.01em;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .28), 0 14px 34px rgba(18, 93, 56, .2);
            transition: transform .24s cubic-bezier(.16, 1, .3, 1), filter .24s ease;
        }

        .submit-button:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        .submit-button:active {
            transform: translateY(1px) scale(.99);
        }

        .panel-footer {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 12px;
        }

        .panel-footer strong {
            color: var(--text);
        }

        @keyframes breathe {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(.72);
                opacity: .72;
            }
        }

        @keyframes sheen {
            0%, 58%, 100% {
                transform: translateX(-40%);
            }
            78% {
                transform: translateX(40%);
            }
        }

        @media (max-width: 940px) {
            .login-shell {
                grid-template-columns: 1fr;
                gap: 28px;
                padding: 92px 0 28px;
            }

            .hero-copy {
                padding-top: 0;
            }

            h1 {
                max-width: 640px;
            }

            .signal-grid {
                grid-template-columns: 1fr;
                margin-top: 26px;
            }
        }

        @media (max-width: 560px) {
            .login-shell {
                width: min(100% - 24px, 1180px);
            }

            .topbar {
                top: 18px;
            }

            .brand span:last-child {
                display: none;
            }

            .back-link {
                padding: 8px 10px;
                font-size: 13px;
            }

            h1 {
                font-size: 42px;
            }

            .hero-copy p {
                font-size: 15px;
            }

            .login-card {
                padding: 22px;
            }

            .panel-header {
                display: grid;
            }

            .secure-pill {
                width: max-content;
            }

            .panel-footer,
            .remember-row {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <header class="topbar" aria-label="Navigasi login admin">
            <a href="{{ route('landing.index') }}" class="brand">
                <span class="brand-mark">
                    <x-brand-mark style="width: 18px; height: 18px;" />
                </span>
                <span class="font-serif italic" style="font-weight:600; font-family: 'Fraunces', Georgia, serif;">MLUP <span style="font-style:normal; font-weight:400; font-family: ui-sans-serif, system-ui, sans-serif;">Academy</span></span>
            </a>
            <a href="{{ route('landing.index') }}" class="back-link">Kembali ke landing</a>
        </header>

        <section class="hero-copy" aria-labelledby="login-title">
            <span class="eyebrow"><span class="status-dot"></span> Admin Console</span>
            <h1 id="login-title">Masuk ke pusat kendali hotline akademik.</h1>
            <p>
                Pantau klik CTA, pesan masuk WhatsApp, grouping referral, dan follow-up mahasiswa dari satu dashboard yang rapi.
            </p>
        </section>

        <section class="login-panel" aria-label="Form login admin">
            <div class="login-card">
                <div class="panel-header">
                    <div>
                        <h2>Login dashboard</h2>
                        <p>Gunakan kredensial admin untuk membuka data hotline.</p>
                    </div>
                    <span class="secure-pill">Protected</span>
                </div>

                @if ($errors->any())
                    <div class="error-box" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="post" action="{{ route('admin.login.store') }}" class="form-stack">
                    @csrf

                    <div class="field">
                        <label for="email">Email admin</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="admin@hotline.local" autocomplete="email" required autofocus>
                        <span class="helper">Akun harus memiliki akses admin.</span>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
                    </div>

                    <div class="remember-row">
                        <label class="check-label" for="remember">
                            <input id="remember" type="checkbox" name="remember" value="1">
                            <span>Tetap login di browser ini</span>
                        </label>
                    </div>

                    <button type="submit" class="submit-button">Masuk Dashboard</button>
                </form>

                <div class="panel-footer">
                    <span>Default lokal: <strong>admin@hotline.local</strong></span>
                    <span>Ubah password lewat <strong>.env</strong></span>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
