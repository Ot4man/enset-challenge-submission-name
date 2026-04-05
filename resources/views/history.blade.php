@extends('layout')

@section('title', 'Emergency History')

@section('extra_css')
<style>
    .history-card { background: var(--card); padding: 2.5rem; border-radius: 1.5rem; border: 1px solid var(--border); }
    table { width: 100%; border-collapse: collapse; margin-top: 2rem; color: var(--text); }
    th { text-align: left; padding: 1rem; color: var(--text-dim); border-bottom: 2px solid var(--border); font-size: 0.9rem; }
    td { padding: 1.2rem; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.95rem; vertical-align: middle; }
    tr:hover td { background: rgba(255,255,255,0.02); }
</style>
@endsection

@section('content')
<div class="history-card">
    <h1>📝 Emergency Log History</h1>
    <p style="color: var(--text-dim);">Historical data of processed emergencies and risk classifications.</p>

    @if($records->isEmpty())
        <div style="text-align: center; margin-top: 3rem; color: var(--text-dim); font-style: italic;">
            No emergencies have been recorded yet.
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Snap</th>
                    <th>Type</th>
                    <th>Risk</th>
                    <th>Input Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $rec)
                @php 
                    $imgMapping = [
                        'fire' => 'https://images.unsplash.com/photo-1542353436-312f02c16299?q=80&w=100',
                        'accident' => 'https://images.unsplash.com/photo-1595085610813-f667ca84d16d?q=80&w=100',
                        'health' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=100',
                        'natural_disaster' => 'https://images.unsplash.com/photo-1511210414434-7389868779b7?q=80&w=100',
                    ];
                    $thumb = $imgMapping[$rec->type] ?? 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=100';
                @endphp
                <tr>
                    <td>{{ $rec->created_at->format('Y-m-d H:i') }}</td>
                    <td><img src="{{ $thumb }}" style="width: 45px; height: 45px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border);"></td>
                    <td style="text-transform: capitalize;">{{ $rec->type }}</td>
                    <td><span class="badge badge-{{ $rec->risk_level }}">{{ $rec->risk_level }}</span></td>
                    <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $rec->message }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
