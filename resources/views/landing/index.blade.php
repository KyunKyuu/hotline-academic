@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="card hero-box">
                <span class="badge">Laravel + WhatsApp Hotline</span>
                <h1>Hotline akademik yang mencatat klik, chat, biodata, dan handover admin.</h1>
                <p>
                    Landing page ini sudah terhubung ke alur CTA WhatsApp. Saat pengunjung klik tombol chat,
                    sistem mencatat analytics klik. Saat user benar-benar mengirim pesan ke nomor bisnis,
                    webhook WhatsApp akan mencatat chat masuk dan menjalankan flow chatbot hotline akademik.
                </p>
                <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:24px;">
                    <a href="{{ route('landing.whatsapp.redirect', ['source' => 'hero', 'campaign' => 'main_cta']) }}" class="button button-primary">
                        Mulai Chat WhatsApp
                    </a>
                    @auth
                        <a href="{{ route('hotline.dashboard') }}" class="button button-secondary">
                            Lihat Dashboard Hotline
                        </a>
                    @else
                        <a href="{{ route('admin.login') }}" class="button button-secondary">
                            Login Admin
                        </a>
                    @endauth
                </div>
                <p class="mini" style="margin-top:16px;">
                    Nomor bisnis aktif: {{ $businessPhone ?: 'belum diatur di file .env' }}
                </p>
            </div>
        </div>
    </section>

    <section style="padding-bottom:48px;">
        <div class="container grid grid-3">
            <div class="card section">
                <span class="badge">1. Track CTA</span>
                <h3>Klik tombol website tercatat</h3>
                <p class="muted">Setiap CTA menuju WhatsApp masuk ke tabel analytics sehingga conversion dari website bisa diukur.</p>
            </div>
            <div class="card section">
                <span class="badge">2. Chatbot</span>
                <h3>Biodata dipandu sampai lengkap</h3>
                <p class="muted">Bot menerima format template. Jika user menjawab tidak rapi, bot fallback ke pertanyaan satu per satu.</p>
            </div>
            <div class="card section">
                <span class="badge">3. Handover</span>
                <h3>Group A dan B siap untuk admin</h3>
                <p class="muted">Referral memisahkan data ke Group A. Tanpa referral masuk Group B, lalu admin follow-up dari dashboard.</p>
            </div>
        </div>
    </section>
@endsection
