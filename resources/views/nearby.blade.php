@extends('layout')

@section('title', 'Nearby Support Services')

@section('extra_css')
<style>
    .nearby-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 2rem; }
    .help-card { background: var(--card); padding: 2rem; border-radius: 1.5rem; border: 1px solid var(--border); transition: 0.3s; }
    .help-card:hover { transform: translateY(-5px); border-color: rgba(239,68,68,0.4); box-shadow: 0 10px 30px rgba(239,68,68,0.1); }
    .icon { font-size: 2.5rem; margin-bottom: 1.5rem; }
</style>
@endsection

@section('content')
<h1>📍 Nearby Emergency Services</h1>
<p style="color: var(--text-dim);">Locating and prioritizing nearest help stations based on your profile.</p>

<div class="nearby-grid">
    @foreach($nearby as $serv)
    <div class="help-card">
        <div class="icon">{{ $serv['icon'] }}</div>
        <h3 style="margin-bottom: 0.5rem; color: var(--text);">{{ $serv['name'] }}</h3>
        <p style="color: var(--primary); font-weight: bold; margin-bottom: 0.4rem;">{{ $serv['type'] }}</p>
        <p style="color: var(--text-dim); font-size: 0.9rem;">Distance: <strong>{{ $serv['distance'] }}</strong></p>
        <button class="btn-primary" style="margin-top: 1.5rem; width: 100%; border-radius: 999px; font-size: 0.85rem;">Get Directions</button>
    </div>
    @endforeach
</div>
@endsection
