@extends('super-admin.layout.app')

@section('content')
<div class="dashboard-main-body">
    
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Super Admin Dashboard</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="bi bi-house" class="icon text-lg"></i>
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
                                    <i class="bi bi-building"></i>
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
                                    <i class="bi bi-people-fill"></i>
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
                                    <i class="bi bi-currency-dollar"></i>
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
                                    <i class="bi bi-box-seam"></i>
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
                                    <i class="bi bi-cart-check"></i>
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
                                    <i class="bi bi-circle-fill"></i>
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
                        <div class="d-flex align-items-center gap-3 mb-12">
                            <div class="d-flex align-items-center flex-shrink-0">
                                <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0" style="color: #487FFF;">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <span class="text-primary-light fw-medium text-sm ps-12 text-nowrap">Active Businesses</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <div class="flex-grow-1">
                                    <div class="progress progress-sm rounded-pill" role="progressbar" style="background-color: #f0f4ff;">
                                        <div class="progress-bar rounded-pill" style="width: {{ $stats['total_businesses'] > 0 ? ($stats['active_businesses'] / $stats['total_businesses']) * 100 : 0 }}%; background-color: #487FFF;"></div>
                                    </div>
                                </div>
                                <span class="text-secondary-light font-xs fw-bold text-nowrap">{{ $stats['total_businesses'] > 0 ? round(($stats['active_businesses'] / $stats['total_businesses']) * 100) : 0 }}%</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center flex-shrink-0">
                                <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-success-main">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <span class="text-primary-light fw-medium text-sm ps-12 text-nowrap">Active Users</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <div class="flex-grow-1">
                                    <div class="progress progress-sm rounded-pill" role="progressbar">
                                        <div class="progress-bar bg-success-main rounded-pill" style="width: {{ $stats['total_users'] > 0 ? ($stats['active_users'] / $stats['total_users']) * 100 : 0 }}%;"></div>
                                    </div>
                                </div>
                                <span class="text-secondary-light font-xs fw-semibold text-nowrap">{{ $stats['total_users'] > 0 ? round(($stats['active_users'] / $stats['total_users']) * 100) : 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Trend Line Graph -->
        <div class="col-xxl-12">
            <div class="card h-100 radius-8 border-0 shadow-sm" style="border-top: 3px solid #487FFF !important;">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-2">
                        <div>
                            <h6 class="mb-2 fw-bold text-lg" style="color: #487FFF;">Platform Revenue Trend</h6>
                            <span class="text-sm fw-medium text-secondary-light">Last 30 days across all businesses</span>
                        </div>
                        <div class="">
                            <a href="{{ route('super-admin.reports.revenue') }}" class="btn btn-sm text-white radius-8 px-16 py-8" style="background-color: #487FFF;" onmouseover="this.style.backgroundColor='#3a6fd9'" onmouseout="this.style.backgroundColor='#487FFF'">
                                View Full Report
                            </a>
                        </div>
                    </div>

                    <div id="revenueTrendChart" class="mt-20"></div>
                </div>
            </div>
        </div>

        <!-- Business Status Distribution Pie Chart -->
        <div class="col-xxl-6">
            <div class="card h-100 radius-8 border-0 shadow-sm">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg">Business Health Status</h6>
                        <a href="{{ route('super-admin.businesses.index') }}" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <i class="bi bi-arrow-right class="icon""></i>
                        </a>
                    </div>
                    @if(array_sum($businessStatusDistribution) > 0)
                    <div id="businessStatusChart" class="mt-20"></div>
                    <div class="mt-24">
                        <div class="d-flex align-items-center justify-content-between mb-12">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px radius-2" style="background-color: #45B369"></span>
                                <span class="text-sm">Active Businesses</span>
                            </div>
                            <span class="text-sm fw-bold">{{ $businessStatusDistribution['active'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-12">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px radius-2" style="background-color: #EA5455"></span>
                                <span class="text-sm">Inactive Businesses</span>
                            </div>
                            <span class="text-sm fw-bold">{{ $businessStatusDistribution['inactive'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-12">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px radius-2" style="background-color: #487FFF"></span>
                                <span class="text-sm">New Businesses (30d)</span>
                            </div>
                            <span class="text-sm fw-bold">{{ $businessStatusDistribution['new'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px radius-2" style="background-color: #FF9F43"></span>
                                <span class="text-sm">Dormant (No Sales)</span>
                            </div>
                            <span class="text-sm fw-bold">{{ $businessStatusDistribution['dormant'] }}</span>
                        </div>
                    </div>
                    @else
                    <p class="text-center text-secondary-light mt-5">No business data available</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Role Distribution Pie Chart -->
        <div class="col-xxl-6">
            <div class="card h-100 radius-8 border-0 shadow-sm">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg">User Role Distribution</h6>
                        <a href="{{ route('super-admin.users.index') }}" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <i class="bi bi-arrow-right class="icon""></i>
                        </a>
                    </div>
                    @if(($userRoleDistribution['business_owners'] + $userRoleDistribution['staff']) > 0)
                    <div id="userRoleChart" class="mt-20"></div>
                    <div class="mt-24">
                        <div class="d-flex align-items-center justify-content-between mb-12">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px radius-2" style="background-color: #487FFF"></span>
                                <span class="text-sm">Business Owners</span>
                            </div>
                            <span class="text-sm fw-bold">{{ $userRoleDistribution['business_owners'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-12">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px radius-2" style="background-color: #45B369"></span>
                                <span class="text-sm">Staff Members</span>
                            </div>
                            <span class="text-sm fw-bold">{{ $userRoleDistribution['staff'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-12">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px radius-2" style="background-color: #00CFE8"></span>
                                <span class="text-sm">Active Owners</span>
                            </div>
                            <span class="text-sm fw-bold">{{ $userRoleDistribution['active_owners'] }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px radius-2" style="background-color: #7367F0"></span>
                                <span class="text-sm">Active Staff</span>
                            </div>
                            <span class="text-sm fw-bold">{{ $userRoleDistribution['active_staff'] }}</span>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-sm fw-medium text-secondary-light">Staff per Business Ratio</span>
                                <span class="text-sm fw-bold" style="color: #487FFF;">{{ $stats['total_businesses'] > 0 ? number_format($userRoleDistribution['staff'] / $stats['total_businesses'], 2) : '0' }}</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <p class="text-center text-secondary-light mt-5">No user data available</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Businesses -->
        <div class="col-xxl-12">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white py-16 px-24 d-flex align-items-center justify-content-between">
                    <h6 class="text-lg fw-bold mb-0" style="color: #487FFF;">Recent Businesses</h6>
                    <a href="{{ route('super-admin.businesses.index') }}" class="fw-bold d-flex align-items-center gap-1" style="color: #487FFF; text-decoration: none;" onmouseover="this.style.color='#3666d4'" onmouseout="this.style.color='#487FFF'">
                        View All
                        <i class="bi bi-arrow-right class="icon""></i>
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
        
        // Platform Growth Chart (sparkline) - Real Data
        var platformGrowthOptions = {
            series: [{
                name: "New Businesses",
                data: @json($businessGrowth->pluck('count')->values()->toArray())
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
                enabled: true,
                y: {
                    formatter: function (val) {
                        return val + " businesses"
                    }
                }
            }
        };
        var platformGrowthChart = new ApexCharts(document.querySelector("#platformGrowthChart"), platformGrowthOptions);
        platformGrowthChart.render();

        // Revenue Trend Line Chart
        var revenueTrendOptions = {
            series: [{
                name: "Revenue",
                data: @json($revenueTrend->pluck('revenue')->values()->toArray())
            }],
            chart: {
                type: "area",
                height: 350,
                toolbar: {
                    show: false
                }
            },
            stroke: {
                curve: "smooth",
                width: 3,
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
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: @json($revenueTrend->pluck('date')->map(function($date) {
                    return \Carbon\Carbon::parse($date)->format('M d');
                })->values()->toArray()),
                labels: {
                    style: {
                        colors: "#A0AEC0",
                        fontSize: "12px"
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: "#A0AEC0",
                        fontSize: "12px"
                    },
                    formatter: function (val) {
                        return "$" + val.toFixed(0)
                    }
                }
            },
            grid: {
                borderColor: "#E2E8F0",
                strokeDashArray: 3,
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$" + val.toFixed(2)
                    }
                }
            }
        };
        var revenueTrendChart = new ApexCharts(document.querySelector("#revenueTrendChart"), revenueTrendOptions);
        revenueTrendChart.render();

        // Business Status Distribution Pie Chart
        @if(array_sum($businessStatusDistribution) > 0)
        if(document.querySelector("#businessStatusChart")) {
            var businessStatusOptions = {
                series: [
                    {{ $businessStatusDistribution['active'] }},
                    {{ $businessStatusDistribution['inactive'] }},
                    {{ $businessStatusDistribution['new'] }},
                    {{ $businessStatusDistribution['dormant'] }}
                ],
                chart: {
                    height: 280,
                    type: "pie",
                },
                labels: ["Active", "Inactive", "New (30d)", "Dormant"],
                colors: ["#45B369", "#EA5455", "#487FFF", "#FF9F43"],
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return Math.round(val) + "%"
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "0%"
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        }
                    }
                }]
            };
            var businessStatusChart = new ApexCharts(document.querySelector("#businessStatusChart"), businessStatusOptions);
            businessStatusChart.render();
        }
        @endif

        // User Role Distribution Pie Chart
        @if(($userRoleDistribution['business_owners'] + $userRoleDistribution['staff']) > 0)
        if(document.querySelector("#userRoleChart")) {
            var userRoleOptions = {
                series: [
                    {{ $userRoleDistribution['business_owners'] }},
                    {{ $userRoleDistribution['staff'] }},
                    {{ $userRoleDistribution['active_owners'] }},
                    {{ $userRoleDistribution['active_staff'] }}
                ],
                chart: {
                    height: 280,
                    type: "pie",
                },
                labels: ["Business Owners", "Staff", "Active Owners", "Active Staff"],
                colors: ["#487FFF", "#45B369", "#00CFE8", "#7367F0"],
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return Math.round(val) + "%"
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "0%"
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        }
                    }
                }]
            };
            var userRoleChart = new ApexCharts(document.querySelector("#userRoleChart"), userRoleOptions);
            userRoleChart.render();
        }
        @endif
    });
</script>

@endsection

