@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Super Admin Dashboard</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
    </ul>
</div>

<!-- Statistics Cards -->
<div class="row gy-4 mb-24">
    <!-- Total Businesses -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-1">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                            <iconify-icon icon="solar:buildings-outline" class="icon"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Businesses</span>
                            <h6 class="fw-semibold mb-0">{{ $stats['total_businesses'] }}</h6>
                        </div>
                    </div>
                </div>
                <p class="text-sm mb-0">
                    <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">
                        {{ $stats['active_businesses'] }} Active
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                            <iconify-icon icon="solar:users-group-rounded-outline" class="icon"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Users</span>
                            <h6 class="fw-semibold mb-0">{{ $stats['total_users'] }}</h6>
                        </div>
                    </div>
                </div>
                <p class="text-sm mb-0">
                    <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">
                        {{ $stats['active_users'] }} Active
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Total Revenue (30 days) -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-info-main flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                            <iconify-icon icon="solar:dollar-minimalistic-outline" class="icon"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-2 fw-medium text-secondary-light text-sm">Revenue (30 days)</span>
                            <h6 class="fw-semibold mb-0">{{ number_format($totalRevenue, 2) }}</h6>
                        </div>
                    </div>
                </div>
                <p class="text-sm mb-0 text-secondary-light">Across all businesses</p>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-4">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-warning-main flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                            <iconify-icon icon="solar:box-outline" class="icon"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Products</span>
                            <h6 class="fw-semibold mb-0">{{ $totalProducts }}</h6>
                        </div>
                    </div>
                </div>
                <p class="text-sm mb-0 text-secondary-light">System-wide</p>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4">
    <!-- Recent Businesses -->
    <div class="col-xxl-6">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                    <h6 class="mb-2 fw-bold text-lg mb-0">Recent Businesses</h6>
                    <a href="{{ route('super-admin.businesses.index') }}" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                        View All
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Business Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBusinesses as $business)
                                <tr>
                                    <td>
                                        <a href="{{ route('super-admin.businesses.show', $business) }}" class="text-primary-600">
                                            {{ $business->name }}
                                        </a>
                                    </td>
                                    <td>{{ $business->email }}</td>
                                    <td>
                                        @if($business->is_active)
                                            <span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4">Active</span>
                                        @else
                                            <span class="badge text-sm fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $business->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary-light">No businesses found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Revenue Businesses -->
    <div class="col-xxl-6">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                    <h6 class="mb-2 fw-bold text-lg mb-0">Top Revenue (30 days)</h6>
                    <a href="{{ route('super-admin.reports.revenue') }}" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                        View Report
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Business Name</th>
                                <th scope="col">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($revenueByBusiness as $business)
                                <tr>
                                    <td>
                                        <a href="{{ route('super-admin.businesses.show', $business) }}" class="text-primary-600">
                                            {{ $business->name }}
                                        </a>
                                    </td>
                                    <td class="fw-semibold">{{ number_format($business->total_revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-secondary-light">No revenue data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- User Distribution -->
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-2 fw-bold text-lg mb-0">User Distribution by Role</h6>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    @foreach($usersByRole as $role => $count)
                        <div class="col-md-3">
                            <div class="p-3 border radius-8">
                                <h6 class="mb-1">{{ ucwords(str_replace('_', ' ', $role)) }}</h6>
                                <p class="text-2xl fw-bold text-primary-600 mb-0">{{ $count }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

