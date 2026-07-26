@extends('layouts.app')

@section('content')
<div class="stack" style="max-width: 780px;">
    <div>
        <a href="{{ route('admin.landing.partners.index') }}" class="mini" style="text-decoration:none; color: var(--primary); font-weight: 500;">&larr; Kembali ke Partner Komunitas</a>
        <h1 class="h1-display" style="margin-top: 12px; margin-bottom: 8px;">{{ $partner->exists ? 'Edit Partner Komunitas' : 'Tambah Partner Komunitas' }}</h1>
        <p class="muted">Tentukan informasi profil komunitas partner beserta program kegiatan bersamanya.</p>
    </div>

    @if($errors->any())
        <div class="card section" style="background: var(--danger-bg); border-color: var(--danger-line); color: var(--danger-text); padding: 16px; border-radius: 8px;">
            <h3 style="margin-top:0; font-size: 16px;">Ada kesalahan input:</h3>
            <ul style="margin:0; padding-left:20px; font-size: 14px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card section">
        <form method="post" action="{{ $partner->exists ? route('admin.landing.partners.update', $partner) : route('admin.landing.partners.store') }}" enctype="multipart/form-data" class="stack">
            @csrf
            @if($partner->exists)
                @method('PUT')
            @endif

            <div class="grid grid-2">
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label style="font-weight:600;">Nama Komunitas</label>
                    <input type="text" name="name" id="partner-name" value="{{ old('name', $partner->name) }}" placeholder="Contoh: GEMUSI" required>
                </div>

                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label style="font-weight:600;">Slug URL</label>
                    <input type="text" name="slug" id="partner-slug" value="{{ old('slug', $partner->slug) }}" placeholder="Contoh: gemusi" required>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline', $partner->tagline) }}" placeholder="Contoh: Generasi Muslim Berprestasi">
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Logo Komunitas</label>
                <input type="file" name="logo" accept="image/*" style="padding: 8px;" {{ $partner->exists ? '' : 'required' }}>
                @if($partner->logo)
                    <div style="margin-top:8px;">
                        <span class="mini" style="display:block; margin-bottom:4px;">Logo saat ini:</span>
                        <img src="{{ asset('images/partners/' . $partner->logo) }}" alt="Current logo" style="max-width:120px; border-radius:6px; border:1px solid var(--hairline);">
                    </div>
                @endif
            </div>

            <div style="display:flex; flex-direction:column; gap:6px;">
                <label style="font-weight:600;">Profil Komunitas</label>
                <textarea name="profile" rows="5" placeholder="Tuliskan cerita singkat atau visi-misi dari komunitas partner...">{{ old('profile', $partner->profile) }}</textarea>
            </div>

            <hr style="border: 0; border-top: 1px solid var(--hairline); margin: 12px 0;">

            <div class="stack">
                <div>
                    <h3 style="margin: 0 0 4px; font-size:16px; font-weight:600;">Kegiatan Komunitas</h3>
                    <p class="mini">Masukkan rincian kegiatan atau program kerja yang dilaksanakan bersama MLUP Academy.</p>
                </div>
                
                <div id="activities-container" style="display: flex; flex-direction: column; gap: 16px;">
                    @php
                        $activities = old('activities', $partner->exists ? $partner->activities : [['title' => '', 'description' => '']]);
                    @endphp
                    
                    @foreach($activities as $index => $activity)
                        <div class="activity-row card" style="padding: 20px; background: var(--canvas-soft); position: relative; border-color: var(--hairline);">
                            <button type="button" class="remove-activity" style="position: absolute; right: 16px; top: 16px; background: transparent; border: none; color: var(--semantic-error); font-weight: 600; cursor: pointer; font-size: 13px;">Hapus</button>
                            
                            <div style="display:flex; flex-direction:column; gap:6px; margin-bottom: 12px;">
                                <label style="font-weight:600; font-size:12px;">Judul Kegiatan</label>
                                <input type="text" name="activities[{{ $index }}][title]" value="{{ $activity['title'] ?? '' }}" placeholder="Contoh: Kajian Bulanan">
                            </div>
                            
                            <div style="display:flex; flex-direction:column; gap:6px;">
                                <label style="font-weight:600; font-size:12px;">Deskripsi Kegiatan</label>
                                <textarea name="activities[{{ $index }}][description]" rows="2" placeholder="Deskripsi singkat kegiatan...">{{ $activity['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div>
                    <button type="button" id="add-activity-btn" class="button button-secondary" style="font-size: 13px; height: 34px;">+ Tambah Kegiatan</button>
                </div>
            </div>

            <div style="display:flex; gap:12px; margin-top:24px; border-top: 1px solid var(--hairline); padding-top:24px;">
                <button type="submit" class="button button-primary">{{ $partner->exists ? 'Perbarui Partner' : 'Tambah Partner' }}</button>
                <a href="{{ route('admin.landing.partners.index') }}" class="button button-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-generate slug from name
        const nameInput = document.getElementById('partner-name');
        const slugInput = document.getElementById('partner-slug');
        
        nameInput.addEventListener('input', function() {
            if (!{{ $partner->exists ? 'true' : 'false' }}) {
                slugInput.value = nameInput.value
                    .toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                    .replace(/-+/g, '-'); // collapse dashes
            }
        });

        // Add/Remove activities logic
        const container = document.getElementById('activities-container');
        const addBtn = document.getElementById('add-activity-btn');
        let index = container.querySelectorAll('.activity-row').length;

        addBtn.addEventListener('click', function () {
            const row = document.createElement('div');
            row.className = 'activity-row card';
            row.style.cssText = 'padding: 20px; background: var(--canvas-soft); position: relative; border-color: var(--hairline); margin-top: 4px;';
            row.innerHTML = `
                <button type="button" class="remove-activity" style="position: absolute; right: 16px; top: 16px; background: transparent; border: none; color: var(--semantic-error); font-weight: 600; cursor: pointer; font-size: 13px;">Hapus</button>
                <div style="display:flex; flex-direction:column; gap:6px; margin-bottom: 12px;">
                    <label style="font-weight:600; font-size:12px;">Judul Kegiatan</label>
                    <input type="text" name="activities[${index}][title]" placeholder="Contoh: Kajian Bulanan">
                </div>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label style="font-weight:600; font-size:12px;">Deskripsi Kegiatan</label>
                    <textarea name="activities[${index}][description]" rows="2" placeholder="Deskripsi singkat kegiatan..."></textarea>
                </div>
            `;
            container.appendChild(row);
            index++;
        });

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-activity')) {
                e.target.closest('.activity-row').remove();
            }
        });
    });
</script>
@endsection
