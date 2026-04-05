@extends('layout')

@section('title', 'Register New Agent - Emergency AI')

@section('extra_css')
<style>
    .auth-card { max-width: 500px; margin: 4rem auto; padding: 3rem; }
    .form-group { margin-bottom: 2rem; }
    label { display: block; margin-bottom: 0.5rem; color: var(--text-dim); font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; }
    input { width: 100%; padding: 1.2rem; border-radius: 12px; background: rgba(0,0,0,0.3); border: 2px solid var(--border); color: #fff; transition: 0.3s; }
</style>
@endsection

@section('content')
<div class="glass-card auth-card">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <h1 style="font-size: 2rem; letter-spacing: -1px;">🖋️ AGENT_REGISTRATION</h1>
        <p style="color: var(--text-dim);">Register your credentials to the AI system.</p>
    </div>

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="form-group">
            <label>FULL_NAME</label>
            <input type="text" name="name" placeholder="Agent Name" required>
        </div>

        <div class="form-group">
            <label>EMAIL_ADDRESS</label>
            <input type="email" name="email" placeholder="agent@emergency.ai" required>
        </div>

        <div class="form-group">
            <label>INITIATE_PASSWORD</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <div class="form-group">
            <label>CONFIRM_PASSWORD</label>
            <input type="password" name="password_confirmation" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; border-radius: 12px; padding: 1.2rem;">Register & Initiate System</button>
    </form>

    <div style="text-align: center; margin-top: 2rem; color: var(--text-dim); font-size: 0.9rem;">
        Already an agent? <a href="{{ route('login') }}" style="color: #fff; font-weight: 700;">PROCEED TO LOGIN ➔</a>
    </div>
</div>
@endsection
