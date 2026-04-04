@extends('layout')

@section('title', 'Emergency History')

@section('extra_css')
<style>
    .history-card { background: var(--card); padding: 2.5rem; border-radius: 1.5rem; border: 1px solid var(--border); }
    table { width: 100%; border-collapse: collapse; margin-top: 2rem; color: var(--text); }
    th { text-align: left; padding: 1rem; color: var(--text-dim); border-bottom: 2px solid var(--border); font-size: 0.9rem; }
    td { padding: 1.2rem; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.95rem; }
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
                    <th>Type</th>
                    <th>Risk</th>
                    <th>Input Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $rec)
                <tr>
                    <td>{{ $rec->created_at->format('Y-m-d H:i') }}</td>
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
