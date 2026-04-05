@extends('layout')

@section('title', 'Login - Emergency Command Node')

@section('extra_css')
<style>
    .auth-card { max-width: 450px; margin: 4rem auto; padding: 3rem; }
    .form-group { margin-bottom: 2rem; }
    label { display: block; margin-bottom: 0.5rem; color: var(--text-dim); font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; }
    input { width: 100%; padding: 1.2rem; border-radius: 12px; background: rgba(0,0,0,0.3); border: 2px solid var(--border); color: #fff; transition: 0.3s; }
    input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 15px rgba(244,63,94,0.2); }
    .auth-footer { text-align: center; margin-top: 2rem; color: var(--text-dim); font-size: 0.9rem; }
</style>
@endsection

@section('content')
<div class="glass-card auth-card">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <h1 style="font-size: 2rem; letter-spacing: -1px;">🔐 AUTH_NODE</h1>
        <p style="color: var(--text-dim);">Enter your credentials to access the terminal.</p>
    </div>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="form-group">
            <label>ID / EMAIL</label>
            <input type="email" name="email" placeholder="agent@emergency.ai" required>
            @error('email') <p style="color: var(--primary); font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>ACCESS_CODE / PASSWORD</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; border-radius: 12px; padding: 1.2rem;">Decrypt & Access</button>
    </form>

    <div class="auth-footer">
        New investigator? <a href="{{ route('register') }}" style="color: #fff; font-weight: 700;">REQUEST ACCESS ➔</a>
    </div>
</div>
@endsection
