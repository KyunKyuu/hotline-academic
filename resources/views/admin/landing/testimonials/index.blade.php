@extends('layouts.app')

@section('content')
<div class="stack">
    <div>
        <span class="badge">Landing Page</span>
        <h1 class="h1-display">Cerita Peserta</h1>
        <p class="muted">Kelola cerita dan testimoni dari peserta/mahasiswa yang ditampilkan di Landing Page utama.</p>
    </div>

    @if(session('status'))
        <div class="card section" style="background: #e6f4ea; border-color: #34a853; color: #137333; padding: 16px; border-radius: 8px;">
            <strong>Sukses!</strong> {{ session('status') }}
        </div>
    @endif

    <div class="card section">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: normal;">Daftar Cerita</h2>
            <a href="{{ route('admin.landing.testimonials.create') }}" class="button button-primary">+ Tambah Cerita</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width:80px; text-align:center;">Avatar</th>
                    <th>Nama</th>
                    <th>Konteks / Detail</th>
                    <th style="width:100px;">Urutan</th>
                    <th style="width:180px; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testi)
                    <tr>
                        <td style="text-align:center; vertical-align:middle;">
                            <span class="pill" style="font-family: var(--font-serif); font-size:16px; width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center;">{{ $testi->avatar }}</span>
                        </td>
                        <td style="vertical-align:middle;"><strong>{{ $testi->name }}</strong></td>
                        <td style="vertical-align:middle; color:var(--ink-subtle);">{{ $testi->context }}</td>
                        <td style="vertical-align:middle;">{{ $testi->order }}</td>
                        <td style="vertical-align:middle; text-align:right;">
                            <div style="display:inline-flex; gap:8px;">
                                <a href="{{ route('admin.landing.testimonials.edit', $testi) }}" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px;">Edit</a>
                                <form method="post" action="{{ route('admin.landing.testimonials.destroy', $testi) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cerita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px; color:#d93025; border-color:#fad2cf;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted" style="text-align: center; padding: 24px 0;">Belum ada cerita peserta yang ditambahkan. Menggunakan data statis default.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
