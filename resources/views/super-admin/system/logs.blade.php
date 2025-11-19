@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">System Logs</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <i class="bi bi-house" class="icon text-lg"></i>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">System Logs</li>
    </ul>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Application Logs</h6>
        <div class="d-flex gap-2">
            <form method="GET" action="{{ route('super-admin.system.logs') }}" class="d-inline">
                <select name="lines" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="100" {{ request('lines', 100) == 100 ? 'selected' : '' }}>Last 100 lines</option>
                    <option value="200" {{ request('lines') == 200 ? 'selected' : '' }}>Last 200 lines</option>
                    <option value="500" {{ request('lines') == 500 ? 'selected' : '' }}>Last 500 lines</option>
                    <option value="1000" {{ request('lines') == 1000 ? 'selected' : '' }}>Last 1000 lines</option>
                </select>
            </form>
            <form method="POST" action="{{ route('super-admin.system.clear-logs') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger-600" 
                        onclick="return confirm('Are you sure you want to clear all logs?')">
                    <i class="bi bi-circle-fill"></i> Clear Logs
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        @if(count($logs) > 0)
            <div class="log-viewer" style="max-height: 600px; overflow-y: auto; background: #1e1e1e; padding: 20px; border-radius: 8px;">
                <pre style="color: #d4d4d4; margin: 0; font-size: 12px; line-height: 1.6;">@foreach($logs as $log)<span style="color: {{ 
                    str_contains($log, 'ERROR') ? '#f48771' : 
                    (str_contains($log, 'WARNING') ? '#dcdcaa' : 
                    (str_contains($log, 'INFO') ? '#4ec9b0' : '#d4d4d4'))
                }};">{{ $log }}</span>
@endforeach</pre>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-circle-fill"></i>
                <p class="text-secondary-light mb-0">No logs available</p>
            </div>
        @endif
    </div>
</div>

<div class="alert alert-info mt-3">
    <h6 class="mb-2"><i class="fas fa-info-circle"></i> Log Information</h6>
    <ul class="mb-0 ps-3">
        <li>Logs are displayed in reverse chronological order (newest first)</li>
        <li>Different log levels are color-coded: <span class="text-danger">ERROR</span>, <span class="text-warning">WARNING</span>, <span class="text-info">INFO</span></li>
        <li>Log file location: <code>storage/logs/laravel.log</code></li>
        <li>Clearing logs will permanently delete all log entries</li>
    </ul>
</div>
@endsection

