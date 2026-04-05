@extends('layout')

@section('title', 'Contact the Developer')

@section('extra_css')
<style>
    .contact-form { background: var(--card); padding: 3rem; border-radius: 2rem; border: 1px solid var(--border); max-width: 600px; margin: 0 auto; }
    .form-group { margin-bottom: 2rem; }
    label { display: block; margin-bottom: 0.5rem; color: var(--text-dim); font-size: 0.9rem; }
    input, textarea { width: 100%; padding: 1.2rem; border-radius: 1rem; background: rgba(0,0,0,0.2); border: 2px solid var(--border); color: white; transition: 0.3s; }
    input:focus, textarea:focus { border-color: var(--primary); outline: none; }
</style>
@endsection

@section('content')
<div class="contact-form">
    <h1>📩 Developer Contact</h1>
    <p style="color: var(--text-dim); margin-bottom: 2rem;">Send your feedback or inquiry about the AI system.</p>

    <form onsubmit="alert('Feedback sent successfully. Our simulated team will review it.'); event.preventDefault();">
        <div class="form-group">
            <label>FULL NAME</label>
            <input type="text" placeholder="Your Name" required>
        </div>

        <div class="form-group">
            <label>EMAIL ADDRESS</label>
            <input type="email" placeholder="Email@example.com" required>
        </div>

        <div class="form-group">
            <label>MESSAGE</label>
            <textarea rows="4" placeholder="Your inquiry or feedback..." required></textarea>
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; border-radius: 999px;">Send Message</button>
    </form>
</div>
@endsection
