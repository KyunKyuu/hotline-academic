@extends('layouts.app')

@section('content')
<div class="stack">
    <div>
        <span class="badge">Landing Page</span>
        <h1 class="h1-display">Momen Kegiatan</h1>
        <p class="muted">Kelola foto-foto galeri kegiatan yang ditampilkan di Landing Page utama.</p>
    </div>

    @if(session('status'))
        <div class="card section" style="background: #e6f4ea; border-color: #34a853; color: #137333; padding: 16px; border-radius: 8px;">
            <strong>Sukses!</strong> {{ session('status') }}
        </div>
    @endif

    <div class="card section">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: normal;">Daftar Momen</h2>
            <a href="{{ route('admin.landing.moments.create') }}" class="button button-primary">+ Tambah Momen</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width:120px;">Gambar</th>
                    <th>Caption</th>
                    <th style="width:100px;">Urutan</th>
                    <th style="width:180px; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($moments as $moment)
                    <tr>
                        <td>
                            <img src="{{ asset('images/gallery/' . $moment->image) }}" alt="moment" style="width:100px; height:70px; object-fit: cover; border-radius:6px; border:1px solid var(--hairline);">
                        </td>
                        <td style="vertical-align:middle;"><strong>{{ $moment->caption }}</strong></td>
                        <td style="vertical-align:middle;">{{ $moment->order }}</td>
                        <td style="vertical-align:middle; text-align:right;">
                            <div style="display:inline-flex; gap:8px;">
                                <a href="{{ route('admin.landing.moments.edit', $moment) }}" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px;">Edit</a>
                                <form method="post" action="{{ route('admin.landing.moments.destroy', $moment) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus momen ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px; color:#d93025; border-color:#fad2cf;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="muted" style="text-align: center; padding: 24px 0;">Belum ada momen kegiatan yang ditambahkan. Menggunakan data statis default.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
