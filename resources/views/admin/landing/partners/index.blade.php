@extends('layouts.app')

@section('content')
<div class="stack">
    <div>
        <span class="badge">Landing Page</span>
        <h1 class="h1-display">Partner Komunitas</h1>
        <p class="muted">Kelola data komunitas mitra aktif yang berkolaborasi dengan MLUP Academy.</p>
    </div>

    @if(session('status'))
        <div class="card section" style="background: #e6f4ea; border-color: #34a853; color: #137333; padding: 16px; border-radius: 8px;">
            <strong>Sukses!</strong> {{ session('status') }}
        </div>
    @endif

    <div class="card section">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 24px;">
            <h2 style="font-size: 20px; font-weight: normal;">Daftar Partner Mitra</h2>
            <a href="{{ route('admin.landing.partners.create') }}" class="button button-primary">+ Tambah Partner</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width:100px;">Logo</th>
                    <th>Nama Komunitas</th>
                    <th>Slug</th>
                    <th>Tagline</th>
                    <th style="width:180px; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr>
                        <td>
                            @if($partner->logo)
                                <img src="{{ asset('images/partners/' . $partner->logo) }}" alt="logo" style="width:50px; height:50px; object-fit:cover; border-radius:50%; border:1px solid var(--hairline);">
                            @else
                                <div style="width:50px; height:50px; border-radius:50%; background:#efeee8; display:flex; align-items:center; justify-content:center; font-weight:bold;">
                                    {{ mb_substr($partner->name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td style="vertical-align:middle;">
                            <strong>{{ $partner->name }}</strong>
                        </td>
                        <td style="vertical-align:middle;"><code>{{ $partner->slug }}</code></td>
                        <td style="vertical-align:middle;" class="muted">{{ $partner->tagline }}</td>
                        <td style="vertical-align:middle; text-align:right;">
                            <div style="display:inline-flex; gap:8px;">
                                <a href="{{ route('admin.landing.partners.edit', $partner) }}" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px;">Edit</a>
                                <form method="post" action="{{ route('admin.landing.partners.destroy', $partner) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px; color:#d93025; border-color:#fad2cf;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted" style="text-align: center; padding: 24px 0;">Belum ada partner komunitas yang ditambahkan. Menggunakan data statis default.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
