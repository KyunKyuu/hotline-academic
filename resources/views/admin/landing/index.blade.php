@extends('layouts.app')

@section('content')
<div class="stack">
    <div>
        <span class="badge">Landing Page</span>
        <h1 class="h1-display">Hero Settings</h1>
        <p class="muted">Sesuaikan media latar belakang, judul, dan subjudul bagian paling atas Landing Page.</p>
    </div>

    @if(session('status'))
        <div class="card section" style="background: #e6f4ea; border-color: #34a853; color: #137333; padding: 16px; border-radius: 8px;">
            <strong>Sukses!</strong> {{ session('status') }}
        </div>
    @endif

    <div class="card section">
        <form method="post" action="{{ route('admin.landing.hero.update') }}" enctype="multipart/form-data" class="stack">
            @csrf
            
            <div class="grid grid-3">
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label style="font-weight:600;">Tipe Hero</label>
                    <select name="hero_type">
                        <option value="pattern" @selected($setting->hero_type === 'pattern')>Pattern (Default SVG)</option>
                        <option value="image" @selected($setting->hero_type === 'image')>Image (Gambar Latar)</option>
                        <option value="video" @selected($setting->hero_type === 'video')>Video (Video Loop)</option>
                    </select>
                </div>

                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label style="font-weight:600;">Upload Gambar Hero</label>
                    <input type="file" name="hero_image" accept="image/*" style="padding: 8px;">
                    @if($setting->hero_image)
                        <div style="margin-top:6px;">
                            <span class="mini">File aktif: <a href="{{ asset('images/hero/' . $setting->hero_image) }}" target="_blank" style="color: var(--primary); text-decoration: underline;">{{ $setting->hero_image }}</a></span>
                        </div>
                    @endif
                </div>

                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label style="font-weight:600;">Upload Video Hero (MP4)</label>
                    <input type="file" name="hero_video" accept="video/mp4" style="padding: 8px;">
                    @if($setting->hero_video)
                        <div style="margin-top:6px;">
                            <span class="mini">File aktif: <a href="{{ asset('videos/' . $setting->hero_video) }}" target="_blank" style="color: var(--primary); text-decoration: underline;">{{ $setting->hero_video }}</a></span>
                        </div>
                    @endif
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Judul Hero</label>
                <input type="text" name="hero_title" value="{{ old('hero_title', $setting->hero_title) }}">
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Subjudul / Deskripsi Hero</label>
                <textarea name="hero_subtitle" rows="4">{{ old('hero_subtitle', $setting->hero_subtitle) }}</textarea>
            </div>

            <div>
                <button type="submit" class="button button-primary">Simpan Pengaturan Hero</button>
            </div>
        </form>
    </div>
</div>
@endsection
