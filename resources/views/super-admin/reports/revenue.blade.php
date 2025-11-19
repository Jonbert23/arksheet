@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Revenue Report</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <i class="bi bi-house" class="icon text-lg"></i>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">
            <a href="{{ route('super-admin.reports.index') }}" class="hover-text-primary">Reports</a>
        </li>
        <li>-</li>
        <li class="fw-medium">Revenue</li>
    </ul>
</div>

<!-- Date Filter -->
<div class="card mb-24">
    <div class="card-body">
        <form method="GET" action="{{ route('super-admin.reports.revenue') }}" class="row g-3">
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
                    <i class="bi bi-circle-fill"></i> Apply Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Total Revenue Card -->
<div class="card mb-24">
    <div class="card-body text-center">
        <h2 class="mb-2">{{ number_format($totalRevenue, 2) }}</h2>
        <p class="text-secondary-light mb-0">Total Revenue ({{ $startDate }} to {{ $endDate }})</p>
    </div>
</div>

<div class="row gy-4">
    <!-- Revenue by Business -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Revenue by Business</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Business Name</th>
                                <th>Total Sales</th>
                                <th>Total Revenue</th>
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
                                    <td>{{ $business->total_sales }}</td>
                                    <td class="fw-semibold">{{ number_format($business->total_revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-secondary-light">No revenue data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue by Payment Method -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">By Payment Method</h6>
            </div>
            <div class="card-body">
                @forelse($revenueByPaymentMethod as $payment)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>{{ ucfirst($payment->payment_method ?? 'N/A') }}</span>
                            <span class="fw-semibold">{{ number_format($payment->total_revenue, 2) }}</span>
                        </div>
                        <small class="text-secondary-light">{{ $payment->total_sales }} sales</small>
                    </div>
                @empty
                    <p class="text-center text-secondary-light mb-0">No data available</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

