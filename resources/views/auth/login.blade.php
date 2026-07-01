@extends('layouts.app')

@section('content')
    <section style="padding: 36px 0 56px;">
        <div class="container" style="max-width: 520px;">
            <div class="card section">
                <span class="badge">Admin Access</span>
                <h1 style="margin: 14px 0 8px;">Login dashboard hotline</h1>
                <p class="muted">Gunakan akun admin untuk melihat analytics, grup referral, dan follow-up mahasiswa.</p>

                @if ($errors->any())
                    <div style="margin:16px 0;padding:14px;border-radius:12px;background:#f7dede;color:#7e2727;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="post" action="{{ route('admin.login.store') }}" class="stack" style="margin-top: 20px;">
                    @csrf
                    <div>
                        <label class="mini">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@hotline.local" required>
                    </div>
                    <div>
                        <label class="mini">Password</label>
                        <input type="password" name="password" placeholder="Password admin" required>
                    </div>
                    <label style="display:flex;gap:10px;align-items:center;">
                        <input type="checkbox" name="remember" value="1">
                        <span class="mini">Tetap login di browser ini</span>
                    </label>
                    <button type="submit" class="button button-primary">Masuk Dashboard</button>
                </form>
            </div>
        </div>
    </section>
@endsection
