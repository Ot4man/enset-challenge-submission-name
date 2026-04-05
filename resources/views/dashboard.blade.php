@extends('layout')

@section('title', 'Admin Dashboard')

@section('extra_css')
<style>
    .dash-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 2rem; margin-top: 3rem; }
    .chart-card { background: var(--card); border: 1px solid var(--border); border-radius: 1.5rem; padding: 2rem; box-shadow: 0 5px 25px rgba(0,0,0,0.2); }
    .stat-card { background: linear-gradient(135deg, rgba(239,68,68,0.2), transparent); border: 1px solid rgba(239,68,68,0.3); padding: 2rem; border-radius: 1rem; text-align: center; }
</style>
@endsection

@section('content')
<h1>📊 Emergency Response Dashboard</h1>
<p style="color: var(--text-dim);">Real-time statistics of processed situations and agent distribution.</p>

<div class="dash-grid">
    <div class="stat-card">
        <h3 style="font-size: 1rem; color: var(--text-dim);">TOTAL EMERGENCIES</h3>
        <p style="font-size: 3rem; font-weight: 800; color: var(--primary);">{{ $total }}</p>
    </div>
    
    <div class="chart-card">
        <h3 style="margin-bottom: 2rem; font-size: 1rem;">🔥 Distribution by Emergency Type</h3>
        <canvas id="typeChart"></canvas>
    </div>

    <div class="chart-card">
        <h3 style="margin-bottom: 2rem; font-size: 1rem;">⚠️ Risk Level Distribution</h3>
        <canvas id="riskChart"></canvas>
    </div>
</div>
@endsection

@section('extra_js')
<script>
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'doughnut',
        data: {
          labels: {!! json_encode(array_keys($byType->toArray())) !!},
          datasets: [{
            data: {!! json_encode(array_values($byType->toArray())) !!},
            backgroundColor: ['#ef4444', '#f59e0b', '#3b82f6', '#10b981', '#6366f1'],
            borderColor: '#1e293b',
            borderWidth: 5
          }]
        },
        options: { plugins: { legend: { position: 'right' } } }
    });

    const riskCtx = document.getElementById('riskChart').getContext('2d');
    new Chart(riskCtx, {
        type: 'bar',
        data: {
          labels: {!! json_encode(array_keys($byRisk->toArray())) !!},
          datasets: [{
            label: 'Incident Count',
            data: {!! json_encode(array_values($byRisk->toArray())) !!},
            backgroundColor: '#ef4444'
          }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });
</script>
@endsection
