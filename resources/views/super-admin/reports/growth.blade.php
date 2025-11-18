@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Growth Report</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">
            <a href="{{ route('super-admin.reports.index') }}" class="hover-text-primary">Reports</a>
        </li>
        <li>-</li>
        <li class="fw-medium">Growth</li>
    </ul>
</div>

<!-- Time Period Filter -->
<div class="card mb-24">
    <div class="card-body">
        <form method="GET" action="{{ route('super-admin.reports.growth') }}" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Time Period</label>
                <select name="months" class="form-select">
                    <option value="6" {{ $months == 6 ? 'selected' : '' }}>Last 6 Months</option>
                    <option value="12" {{ $months == 12 ? 'selected' : '' }}>Last 12 Months</option>
                    <option value="24" {{ $months == 24 ? 'selected' : '' }}>Last 24 Months</option>
                </select>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary-600 w-100">
                    <iconify-icon icon="solar:magnifer-linear"></iconify-icon> Apply Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Growth Rate Card -->
<div class="card mb-24">
    <div class="card-body text-center">
        <h2 class="mb-2 {{ $businessGrowthRate >= 0 ? 'text-success-600' : 'text-danger-600' }}">
            {{ $businessGrowthRate >= 0 ? '+' : '' }}{{ number_format($businessGrowthRate, 2) }}%
        </h2>
        <p class="text-secondary-light mb-0">Business Growth Rate (Month over Month)</p>
    </div>
</div>

<div class="row gy-4">
    <!-- Business Growth -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Business Growth</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>New Businesses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($businessGrowth as $data)
                                <tr>
                                    <td>{{ $data->month }}</td>
                                    <td class="fw-semibold">{{ $data->count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-secondary-light">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- User Growth -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">User Growth</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>New Users</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($userGrowth as $data)
                                <tr>
                                    <td>{{ $data->month }}</td>
                                    <td class="fw-semibold">{{ $data->count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-secondary-light">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Growth -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Revenue Growth</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Revenue</th>
                                <th>Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($revenueGrowth as $data)
                                <tr>
                                    <td>{{ $data->month }}</td>
                                    <td class="fw-semibold">{{ number_format($data->revenue, 2) }}</td>
                                    <td>{{ $data->sales_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-secondary-light">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Growth -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Product Growth</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>New Products</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productGrowth as $data)
                                <tr>
                                    <td>{{ $data->month }}</td>
                                    <td class="fw-semibold">{{ $data->count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-secondary-light">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

