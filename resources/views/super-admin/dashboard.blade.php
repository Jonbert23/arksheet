@extends('super-admin.layout.app')

@section('content')
<div class="dashboard-main-body">
    
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

    <div class="row gy-4">
        <!-- Statistics Cards Row -->
        <div class="col-xxl-8">
            <div class="row gy-4">
                
                <!-- Total Businesses -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #f0f4ff 0%, #ffffff 100%); border-left: 4px solid #487FFF !important;">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center gap-2 mb-8">
                                <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #487FFF;">
                                    <iconify-icon icon="solar:buildings-outline" class="icon"></iconify-icon>
                                </span>
                                <div class="flex-grow-1">
                                    <span class="d-block fw-medium text-secondary-light text-sm mb-1">Businesses</span>
                                    <h6 class="fw-bold mb-0" style="color: #487FFF;">{{ $stats['total_businesses'] }}</h6>
                                </div>
                            </div>
                            <p class="text-sm mb-0">Active <span class="px-1 rounded-2 fw-bold text-white text-sm" style="background-color: #45B369;">{{ $stats['active_businesses'] }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center gap-2 mb-8">
                                <span class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                    <iconify-icon icon="solar:users-group-rounded-outline" class="icon"></iconify-icon>
                                </span>
                                <div class="flex-grow-1">
                                    <span class="d-block fw-medium text-secondary-light text-sm mb-1">Total Users</span>
                                    <h6 class="fw-semibold mb-0">{{ $stats['total_users'] }}</h6>
                                </div>
                            </div>
                            <p class="text-sm mb-0">Active <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">{{ $stats['active_users'] }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center gap-2 mb-8">
                                <span class="mb-0 w-48-px h-48-px bg-yellow text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <iconify-icon icon="solar:dollar-minimalistic-outline" class="icon"></iconify-icon>
                                </span>
                                <div class="flex-grow-1">
                                    <span class="d-block fw-medium text-secondary-light text-sm mb-1">Revenue (30d)</span>
                                    <h6 class="fw-semibold mb-0">${{ number_format($totalRevenue, 2) }}</h6>
                                </div>
                            </div>
                            <p class="text-sm mb-0">All <span class="bg-info-focus px-1 rounded-2 fw-medium text-info-main text-sm">{{ $stats['total_businesses'] }} businesses</span></p>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center gap-2 mb-8">
                                <span class="mb-0 w-48-px h-48-px bg-purple text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <iconify-icon icon="solar:box-outline" class="icon"></iconify-icon>
                                </span>
                                <div class="flex-grow-1">
                                    <span class="d-block fw-medium text-secondary-light text-sm mb-1">Products</span>
                                    <h6 class="fw-semibold mb-0">{{ number_format($totalProducts) }}</h6>
                                </div>
                            </div>
                            <p class="text-sm mb-0">System <span class="bg-purple-focus px-1 rounded-2 fw-medium text-purple text-sm">wide</span></p>
                        </div>
                    </div>
                </div>

                <!-- Total Sales -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-5">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center gap-2 mb-8">
                                <span class="mb-0 w-48-px h-48-px bg-pink text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <iconify-icon icon="fluent:cart-16-filled" class="icon"></iconify-icon>
                                </span>
                                <div class="flex-grow-1">
                                    <span class="d-block fw-medium text-secondary-light text-sm mb-1">Total Sales</span>
                                    <h6 class="fw-semibold mb-0">{{ $stats['total_sales'] ?? 0 }}</h6>
                                </div>
                            </div>
                            <p class="text-sm mb-0">Last <span class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm">30 days</span></p>
                        </div>
                    </div>
                </div>

                <!-- Growth Rate -->
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-6">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center gap-2 mb-8">
                                <span class="mb-0 w-48-px h-48-px bg-cyan text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <iconify-icon icon="solar:chart-2-outline" class="icon"></iconify-icon>
                                </span>
                                <div class="flex-grow-1">
                                    <span class="d-block fw-medium text-secondary-light text-sm mb-1">Growth Rate</span>
                                    <h6 class="fw-semibold mb-0">{{ $stats['growth_rate'] ?? 0 }}%</h6>
                                </div>
                            </div>
                            <p class="text-sm mb-0">Month <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">over month</span></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Business Growth Chart -->
        <div class="col-xxl-4">
            <div class="card h-100 radius-8 border-0 shadow-sm" style="border-top: 3px solid #487FFF !important;">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <div>
                            <h6 class="mb-2 fw-bold text-lg" style="color: #487FFF;">Platform Growth</h6>
                            <span class="text-sm fw-medium text-secondary-light">Last 30 days</span>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-2 fw-bold text-lg">{{ $stats['total_businesses'] }}</h6>
                            <span class="ps-12 pe-12 pt-2 pb-2 rounded-2 fw-bold text-white text-sm" style="background-color: #487FFF;">Total</span>
                        </div>
                    </div>
                    <div id="platformGrowthChart" class="mt-28"></div>
                    
                    <div class="mt-20">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                            <div class="d-flex align-items-center">
                                <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0" style="color: #487FFF;">
                                    <iconify-icon icon="solar:buildings-outline" class="icon"></iconify-icon>
                                </span>
                                <span class="text-primary-light fw-medium text-sm ps-12">Active Businesses</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 w-100">
                                <div class="w-100 max-w-66 ms-auto">
                                    <div class="progress progress-sm rounded-pill" role="progressbar" style="background-color: #f0f4ff;">
                                        <div class="progress-bar rounded-pill" style="width: {{ $stats['total_businesses'] > 0 ? ($stats['active_businesses'] / $stats['total_businesses']) * 100 : 0 }}%; background-color: #487FFF;"></div>
                                    </div>
                                </div>
                                <span class="text-secondary-light font-xs fw-bold">{{ $stats['total_businesses'] > 0 ? round(($stats['active_businesses'] / $stats['total_businesses']) * 100) : 0 }}%</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center">
                                <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-success-main">
                                    <iconify-icon icon="solar:users-group-rounded-outline" class="icon"></iconify-icon>
                                </span>
                                <span class="text-primary-light fw-medium text-sm ps-12">Active Users</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 w-100">
                                <div class="w-100 max-w-66 ms-auto">
                                    <div class="progress progress-sm rounded-pill" role="progressbar">
                                        <div class="progress-bar bg-success-main rounded-pill" style="width: {{ $stats['total_users'] > 0 ? ($stats['active_users'] / $stats['total_users']) * 100 : 0 }}%;"></div>
                                    </div>
                                </div>
                                <span class="text-secondary-light font-xs fw-semibold">{{ $stats['total_users'] > 0 ? round(($stats['active_users'] / $stats['total_users']) * 100) : 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Businesses -->
        <div class="col-xxl-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white py-16 px-24 d-flex align-items-center justify-content-between">
                    <h6 class="text-lg fw-bold mb-0" style="color: #487FFF;">Recent Businesses</h6>
                    <a href="{{ route('super-admin.businesses.index') }}" class="fw-bold d-flex align-items-center gap-1" style="color: #487FFF; text-decoration: none;" onmouseover="this.style.color='#3666d4'" onmouseout="this.style.color='#487FFF'">
                        View All
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                    </a>
                </div>
                <div class="card-body p-24">
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
                                            <div>
                                                <span class="text-md d-block line-height-1 fw-medium text-primary-light text-w-200-px">{{ $business->name }}</span>
                                            </div>
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
                                        <td colspan="4" class="text-center py-4">No businesses found</td>
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
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white py-16 px-24 d-flex align-items-center justify-content-between">
                    <h6 class="text-lg fw-bold mb-0" style="color: #45B369;">Top Revenue (30 days)</h6>
                    <a href="{{ route('super-admin.reports.revenue') }}" class="fw-bold d-flex align-items-center gap-1" style="color: #45B369; text-decoration: none;" onmouseover="this.style.color='#3a9557'" onmouseout="this.style.color='#45B369'">
                        View Report
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                    </a>
                </div>
                <div class="card-body p-24">
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
                                            <div>
                                                <span class="text-md d-block line-height-1 fw-medium text-primary-light text-w-200-px">{{ $business->name }}</span>
                                            </div>
                                        </td>
                                        <td><span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">${{ number_format($business->total_revenue, 2) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4">No revenue data available</td>
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
            <div class="card h-100 radius-8 border-0">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-3">
                        <h6 class="mb-2 fw-bold text-lg">User Distribution by Role</h6>
                    </div>
                    <div class="row gy-3">
                        @foreach($usersByRole as $role => $count)
                            <div class="col-md-3">
                                <div class="p-3 border radius-8 hover-shadow">
                                    <h6 class="mb-1 text-secondary-light">{{ ucwords(str_replace('_', ' ', $role)) }}</h6>
                                    <p class="text-2xl fw-bold mb-0" style="color: #487FFF;">{{ $count }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* Brand Color Focus States */
    .form-control:focus,
    .form-select:focus {
        border-color: #487FFF !important;
        box-shadow: 0 0 0 0.2rem rgba(72, 127, 255, 0.15) !important;
    }
    
    /* Hover effects for stat cards */
    .card:hover {
        transform: translateY(-2px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    /* Link hover effects */
    a:hover {
        transition: color 0.2s ease;
    }
    
    /* Table row hover */
    .table tbody tr:hover {
        background-color: #f0f4ff !important;
        transition: background-color 0.2s ease;
    }
    
    /* Progress bars smooth animation */
    .progress-bar {
        transition: width 0.6s ease;
    }
    
    /* Smooth transitions for cards */
    .card {
        transition: all 0.3s ease;
    }
    
    /* Hover shadow effect */
    .hover-shadow:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }
</style>

<script>
    window.addEventListener('load', function() {
        // Check if ApexCharts is loaded
        if (typeof ApexCharts === 'undefined') {
            console.error('ApexCharts is not loaded!');
            return;
        }
        
        // Platform Growth Chart (sparkline)
        var platformGrowthOptions = {
            series: [{
                name: "Growth",
                data: [10, 15, 13, 17, 21, 25, 28, 30]
            }],
            chart: {
                type: "area",
                height: 100,
                sparkline: {
                    enabled: true
                }
            },
            stroke: {
                curve: "smooth",
                width: 2,
                colors: ["#487FFF"]
            },
            fill: {
                type: "gradient",
                gradient: {
                    shade: "light",
                    type: "vertical",
                    shadeIntensity: 0.5,
                    gradientToColors: ["#487FFF"],
                    inverseColors: false,
                    opacityFrom: 0.6,
                    opacityTo: 0.1,
                }
            },
            tooltip: {
                enabled: true
            }
        };
        var platformGrowthChart = new ApexCharts(document.querySelector("#platformGrowthChart"), platformGrowthOptions);
        platformGrowthChart.render();
    });
</script>

@endsection

