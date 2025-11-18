@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">{{ $business->name }}</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">
            <a href="{{ route('super-admin.businesses.index') }}" class="hover-text-primary">Businesses</a>
        </li>
        <li>-</li>
        <li class="fw-medium">{{ $business->name }}</li>
    </ul>
</div>

<!-- Business Info Card -->
<div class="card mb-24">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Business Information</h6>
        <div class="d-flex gap-2">
            <form method="POST" action="{{ route('super-admin.businesses.toggle-status', $business) }}" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm btn-{{ $business->is_active ? 'warning' : 'success' }}-600">
                    <iconify-icon icon="solar:{{ $business->is_active ? 'eye-closed-linear' : 'check-circle-linear' }}"></iconify-icon>
                    {{ $business->is_active ? 'Deactivate' : 'Activate' }}
                </button>
            </form>
            <a href="{{ route('super-admin.businesses.edit', $business) }}" class="btn btn-sm btn-primary-600">
                <iconify-icon icon="solar:pen-linear"></iconify-icon> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-secondary-light" width="150">Business Name:</td>
                        <td class="fw-semibold">{{ $business->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Email:</td>
                        <td>{{ $business->email }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Phone:</td>
                        <td>{{ $business->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Address:</td>
                        <td>{{ $business->address ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-secondary-light" width="150">Currency:</td>
                        <td class="fw-semibold">{{ $business->currency }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Timezone:</td>
                        <td>{{ $business->timezone }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Status:</td>
                        <td>
                            @if($business->is_active)
                                <span class="badge bg-success-100 text-success-600">Active</span>
                            @else
                                <span class="badge bg-danger-100 text-danger-600">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-secondary-light">Created:</td>
                        <td>{{ $business->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row gy-4 mb-24">
    <div class="col-xxl-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-2">{{ $stats['total_users'] }}</h4>
                <span class="text-secondary-light">Total Users</span>
                <p class="text-sm mb-0 mt-2">
                    <span class="text-success-600">{{ $stats['active_users'] }} Active</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-2">{{ $stats['total_products'] }}</h4>
                <span class="text-secondary-light">Total Products</span>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-2">{{ $stats['total_sales'] }}</h4>
                <span class="text-secondary-light">Total Sales</span>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-2">{{ number_format($stats['total_revenue'], 2) }}</h4>
                <span class="text-secondary-light">Total Revenue</span>
                <p class="text-sm mb-0 mt-2">
                    <span class="text-info-600">{{ number_format($stats['revenue_this_month'], 2) }} This Month</span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4">
    <!-- Users List -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Users</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($business->users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-primary-100 text-primary-600">
                                            {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge bg-success-100 text-success-600">Active</span>
                                        @else
                                            <span class="badge bg-danger-100 text-danger-600">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary-light">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sales -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Recent Sales</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                                <tr>
                                    <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                                    <td class="fw-semibold">{{ number_format($sale->total, 2) }}</td>
                                    <td>{{ $sale->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-secondary-light">No sales found</td>
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

