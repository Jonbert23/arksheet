@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">System Settings</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">System Settings</li>
    </ul>
</div>

<div class="row gy-4">
    <!-- System Information -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">System Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-secondary-light" width="180">PHP Version:</td>
                        <td class="fw-semibold">{{ $systemInfo['php_version'] }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Laravel Version:</td>
                        <td class="fw-semibold">{{ $systemInfo['laravel_version'] }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Database:</td>
                        <td class="fw-semibold">{{ ucfirst($systemInfo['database_type']) }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Cache Driver:</td>
                        <td class="fw-semibold">{{ ucfirst($systemInfo['cache_driver']) }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Queue Driver:</td>
                        <td class="fw-semibold">{{ ucfirst($systemInfo['queue_driver']) }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Timezone:</td>
                        <td class="fw-semibold">{{ $systemInfo['timezone'] }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Environment:</td>
                        <td>
                            <span class="badge bg-{{ $systemInfo['environment'] === 'production' ? 'success' : 'warning' }}-100 
                                         text-{{ $systemInfo['environment'] === 'production' ? 'success' : 'warning' }}-600">
                                {{ ucfirst($systemInfo['environment']) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Storage Information -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">Storage Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary-light">Disk Usage</span>
                        <span class="fw-semibold">
                            {{ number_format($diskInfo['used_space'] / 1024 / 1024 / 1024, 2) }} GB / 
                            {{ number_format($diskInfo['total_space'] / 1024 / 1024 / 1024, 2) }} GB
                        </span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-primary-600" role="progressbar" 
                             style="width: {{ ($diskInfo['used_space'] / $diskInfo['total_space']) * 100 }}%">
                        </div>
                    </div>
                </div>

                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-secondary-light" width="180">Total Space:</td>
                        <td class="fw-semibold">{{ number_format($diskInfo['total_space'] / 1024 / 1024 / 1024, 2) }} GB</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Used Space:</td>
                        <td class="fw-semibold">{{ number_format($diskInfo['used_space'] / 1024 / 1024 / 1024, 2) }} GB</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Free Space:</td>
                        <td class="fw-semibold text-success-600">{{ number_format($diskInfo['free_space'] / 1024 / 1024 / 1024, 2) }} GB</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Database Size:</td>
                        <td class="fw-semibold">{{ number_format($databaseSize, 2) }} MB</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Cache Size:</td>
                        <td class="fw-semibold">{{ number_format($cacheSize, 2) }} MB</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- System Actions -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">System Maintenance</h6>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <!-- Clear Cache -->
                    <div class="col-md-6 col-lg-3">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="w-48-px h-48-px bg-primary-100 text-primary-600 rounded d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:refresh-outline" class="text-2xl"></iconify-icon>
                                </div>
                                <div>
                                    <h6 class="mb-0">Clear Cache</h6>
                                    <p class="text-sm text-secondary-light mb-0">Clear all caches</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('super-admin.system.clear-cache') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary-600 w-100" 
                                        onclick="return confirm('Are you sure you want to clear all caches?')">
                                    Clear Cache
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Optimize Application -->
                    <div class="col-md-6 col-lg-3">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="w-48-px h-48-px bg-success-100 text-success-600 rounded d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:settings-minimalistic-outline" class="text-2xl"></iconify-icon>
                                </div>
                                <div>
                                    <h6 class="mb-0">Optimize</h6>
                                    <p class="text-sm text-secondary-light mb-0">Optimize application</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('super-admin.system.optimize') }}">
                                @csrf
                                <button type="submit" class="btn btn-success-600 w-100"
                                        onclick="return confirm('Are you sure you want to optimize the application?')">
                                    Optimize
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Run Migrations -->
                    <div class="col-md-6 col-lg-3">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="w-48-px h-48-px bg-info-100 text-info-600 rounded d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:database-outline" class="text-2xl"></iconify-icon>
                                </div>
                                <div>
                                    <h6 class="mb-0">Migrate</h6>
                                    <p class="text-sm text-secondary-light mb-0">Run migrations</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('super-admin.system.migrate') }}">
                                @csrf
                                <button type="submit" class="btn btn-info-600 w-100"
                                        onclick="return confirm('Are you sure you want to run database migrations?')">
                                    Run Migrations
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Clear Logs -->
                    <div class="col-md-6 col-lg-3">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="w-48-px h-48-px bg-danger-100 text-danger-600 rounded d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-outline" class="text-2xl"></iconify-icon>
                                </div>
                                <div>
                                    <h6 class="mb-0">Clear Logs</h6>
                                    <p class="text-sm text-secondary-light mb-0">Delete log files</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('super-admin.system.clear-logs') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger-600 w-100"
                                        onclick="return confirm('Are you sure you want to clear all log files?')">
                                    Clear Logs
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

