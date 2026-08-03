@extends('layouts.app')

@section('content')
<div class="stack">
    <div>
        <span class="badge">Dashboard Hotline</span>
        <h1 class="h1-display">Analytics &amp; Antrean Admin</h1>
        <p class="muted">Pantau aktivitas lead masuk WhatsApp, A/B referral group, dan status follow-up mahasiswa.</p>
    </div>

    <div class="grid grid-3">
        <div class="card metric"><span class="muted">CTA Clicked</span><strong>{{ $summary['cta_clicked'] }}</strong></div>
        <div class="card metric"><span class="muted">User Sudah Chat</span><strong>{{ $summary['chatted'] }}</strong></div>
        <div class="card metric"><span class="muted">Biodata Lengkap</span><strong>{{ $summary['biodata_completed'] }}</strong></div>
        <div class="card metric"><span class="muted">Group A</span><strong>{{ $summary['group_a'] }}</strong></div>
        <div class="card metric"><span class="muted">Group B</span><strong>{{ $summary['group_b'] }}</strong></div>
        <div class="card metric"><span class="muted">Waiting Admin</span><strong>{{ $summary['waiting_admin'] }}</strong></div>
    </div>

    <div class="grid grid-3">
        <!-- Filter Kontak -->
        <div class="card section" style="display:flex; flex-direction:column;">
            <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Filter Kontak</h3>
            <form method="get" class="filters" style="display:flex; flex-direction:column; gap:12px;">
                <input type="hidden" name="segment" value="{{ $segment }}">
                
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label>Group</label>
                    <select name="group">
                        <option value="">Semua</option>
                        <option value="A" @selected($group === 'A')>Group A</option>
                        <option value="B" @selected($group === 'B')>Group B</option>
                    </select>
                </div>
                
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label>Kampus</label>
                    <input type="text" name="campus" value="{{ $campus }}" placeholder="Contoh: Universitas Indonesia">
                </div>

                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label>Kode Referral</label>
                    <select name="referral_code">
                        <option value="">Semua</option>
                        @foreach($referralCodesList as $ref)
                            <option value="{{ $ref->code }}" @selected($referralCode === $ref->code)>{{ $ref->name }} ({{ $ref->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label>Status Follow Up</label>
                    <select name="status">
                        <option value="">Semua</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="in_progress" @selected($status === 'in_progress')>In Progress</option>
                        <option value="done" @selected($status === 'done')>Done</option>
                    </select>
                </div>

                <div style="margin-top:4px;">
                    <button type="submit" class="button button-primary" style="width:100%;">Filter</button>
                </div>
            </form>
        </div>

        <!-- Top Kampus -->
        <div class="card section" style="display:flex; flex-direction:column; max-height:430px;">
            <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Top Kampus</h3>
            <div style="flex:1; overflow-y:auto; padding-right:8px; display:flex; flex-direction:column; gap:12px;">
                @forelse($campusBreakdown as $item)
                    <a href="{{ request()->fullUrlWithQuery(['campus' => $item->campus]) }}" class="clickable-item">
                        <span>{{ $item->campus }}</span>
                        <strong>{{ $item->total }}</strong>
                    </a>
                @empty
                    <p class="muted" style="font-size:14px;">Belum ada data kampus.</p>
                @endforelse
            </div>
        </div>

        <!-- Top Referral -->
        <div class="card section" style="display:flex; flex-direction:column; max-height:430px;">
            <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Top Referral</h3>
            <div style="flex:1; overflow-y:auto; padding-right:8px; display:flex; flex-direction:column; gap:12px;">
                @forelse($referralBreakdown as $item)
                    <a href="{{ request()->fullUrlWithQuery(['referral_code' => $item->code]) }}" class="clickable-item">
                        <span>{{ $item->name }} ({{ $item->code }})</span>
                        <strong>{{ $item->usage_count }}</strong>
                    </a>
                @empty
                    <p class="muted" style="font-size:14px;">Belum ada data referral.</p>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .tabs-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            border-bottom: 1px solid var(--hairline);
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .tab-link {
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 500;
            color: var(--ink-subtle);
            border-radius: 6px;
            transition: all 0.15s;
            background: transparent;
            border: 1px solid transparent;
            text-decoration: none;
            display: inline-block;
        }
        .tab-link:hover {
            color: var(--ink);
            background-color: var(--surface-2);
        }
        .tab-link.active {
            color: var(--ink);
            background-color: var(--surface-3);
            border: 1px solid var(--hairline-strong);
        }
        .clickable-item {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            font-size: 13.5px;
            border-bottom: 1px solid var(--hairline);
            padding-bottom: 8px;
            text-decoration: none;
            color: inherit;
            transition: all 0.15s;
        }
        .clickable-item:hover {
            color: var(--primary);
            border-bottom-color: var(--primary);
            padding-left: 4px;
        }
    </style>

    <div class="card section">
        <h3 style="margin-top:0; font-size:18px; font-weight:normal; margin-bottom:16px;">Kontak Hotline</h3>
        
        <div class="tabs-container">
            <a href="{{ request()->fullUrlWithQuery(['segment' => 'all']) }}" class="tab-link {{ $segment === 'all' ? 'active' : '' }}">Semua</a>
            <a href="{{ request()->fullUrlWithQuery(['segment' => 'pending']) }}" class="tab-link {{ $segment === 'pending' ? 'active' : '' }}">Belum Ditangani</a>
            <a href="{{ request()->fullUrlWithQuery(['segment' => 'in_progress']) }}" class="tab-link {{ $segment === 'in_progress' ? 'active' : '' }}">Sedang Diproses</a>
            <a href="{{ request()->fullUrlWithQuery(['segment' => 'done']) }}" class="tab-link {{ $segment === 'done' ? 'active' : '' }}">Selesai</a>
            <a href="{{ request()->fullUrlWithQuery(['segment' => 'group_a']) }}" class="tab-link {{ $segment === 'group_a' ? 'active' : '' }}">Group A</a>
            <a href="{{ request()->fullUrlWithQuery(['segment' => 'group_b']) }}" class="tab-link {{ $segment === 'group_b' ? 'active' : '' }}">Group B</a>
        </div>

        @if(request()->anyFilled(['group', 'campus', 'status', 'referral_code']))
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px; flex-wrap:wrap; font-size:13px; background: var(--surface-2); padding: 10px 14px; border-radius: 8px; border: 1px solid var(--hairline);">
                <span class="muted">Filter aktif:</span>
                @if(filled($group))
                    <span class="pill" style="background:var(--surface-3); border:1px solid var(--hairline-strong); padding: 3px 8px; border-radius: 4px; font-size: 11.5px;">Group: {{ $group }}</span>
                @endif
                @if(filled($campus))
                    <span class="pill" style="background:var(--surface-3); border:1px solid var(--hairline-strong); padding: 3px 8px; border-radius: 4px; font-size: 11.5px;">Kampus: {{ $campus }}</span>
                @endif
                @if(filled($referralCode))
                    <span class="pill" style="background:var(--surface-3); border:1px solid var(--hairline-strong); padding: 3px 8px; border-radius: 4px; font-size: 11.5px;">Referral: {{ $referralCode }}</span>
                @endif
                @if(filled($status))
                    <span class="pill" style="background:var(--surface-3); border:1px solid var(--hairline-strong); padding: 3px 8px; border-radius: 4px; font-size: 11.5px;">Status: {{ $status }}</span>
                @endif
                <a href="{{ route('hotline.dashboard', ['segment' => $segment]) }}" style="color:var(--semantic-error); text-decoration:none; font-weight:600; margin-left:8px; font-size: 12.5px;">Hapus Semua Filter</a>
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Nomor WA</th>
                    <th>Kampus</th>
                    <th>Group</th>
                    <th>State Chat</th>
                    <th>Status Follow Up</th>
                    <th style="text-align:right;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td><strong>{{ $contact->name ?: $contact->wa_name ?: '-' }}</strong></td>
                        <td>{{ $contact->phone_number }}</td>
                        <td>{{ $contact->campus ?: '-' }}</td>
                        <td>
                            @if($contact->group_type)
                                <span class="pill">Group {{ $contact->group_type }}@if($contact->group_type === 'A' && $contact->referralCode) ({{ $contact->referralCode->name }})@endif</span>
                            @else
                                <span class="muted">-</span>
                            @endif
                        </td>
                        <td><code>{{ $contact->chat_state }}</code></td>
                        <td>
                            @php
                                $fuStatus = optional($contact->followUps->first())->status ?: 'pending';
                            @endphp
                            <span class="pill" style="{{ $fuStatus === 'done' ? 'background:#d8ecd9; color:#125d38;' : ($fuStatus === 'in_progress' ? 'background:#fff3cd; color:#856404;' : '') }}">
                                {{ $fuStatus }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('hotline.contacts.show', $contact) }}" class="button button-secondary" style="padding: 6px 12px; font-size:13px; height: 32px; border-radius:6px;">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="muted" style="text-align: center; padding: 24px 0;">Belum ada kontak yang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $contacts->links() }}
        </div>
    </div>


</div>
@endsection
