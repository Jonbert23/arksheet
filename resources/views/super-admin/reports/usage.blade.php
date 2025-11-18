@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Usage Report</h6>
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
        <li class="fw-medium">Usage</li>
    </ul>
</div>

<!-- Date Filter -->
<div class="card mb-24">
    <div class="card-body">
        <form method="GET" action="{{ route('super-admin.reports.usage') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary-600 w-100">
                    <iconify-icon icon="solar:magnifer-linear"></iconify-icon> Apply Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row gy-4">
    <!-- Most Active Businesses -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Most Active Businesses</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Business</th>
                                <th>Users</th>
                                <th>Products</th>
                                <th>Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mostActiveBusinesses as $business)
                                <tr>
                                    <td>
                                        <a href="{{ route('super-admin.businesses.show', $business) }}" class="text-primary-600">
                                            {{ $business->name }}
                                        </a>
                                    </td>
                                    <td>{{ $business->user_count }}</td>
                                    <td>{{ $business->product_count }}</td>
                                    <td class="fw-semibold">{{ $business->sales_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary-light">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Least Active Businesses -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Least Active Businesses</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Business</th>
                                <th>Users</th>
                                <th>Products</th>
                                <th>Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leastActiveBusinesses as $business)
                                <tr>
                                    <td>
                                        <a href="{{ route('super-admin.businesses.show', $business) }}" class="text-primary-600">
                                            {{ $business->name }}
                                        </a>
                                    </td>
                                    <td>{{ $business->user_count }}</td>
                                    <td>{{ $business->product_count }}</td>
                                    <td class="fw-semibold">{{ $business->sales_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary-light">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Inactive Businesses -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Inactive Businesses (No Sales in Period)</h6>
            </div>
            <div class="card-body">
                @if($inactiveBusinesses->count() > 0)
                    <div class="alert alert-warning">
                        <strong>{{ $inactiveBusinesses->count() }}</strong> businesses have no sales activity in the selected period.
                    </div>
                @else
                    <p class="text-success-600 mb-0">All businesses are active!</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

