<x-layout.master>

    @push('styles')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">
    
    <style>
        /* Quick select buttons styling */
        .quick-date-btn {
            transition: all 0.2s ease;
            font-size: 16px;
            padding: 8px 0 !important;
            border-radius: 0 !important;
            background-color: transparent !important;
            border: none !important;
            color: #1f2937 !important;
            font-weight: 600 !important;
        }
        
        .quick-date-btn:hover {
            background-color: transparent !important;
            color: #ec3737 !important;
            border: none !important;
        }
        
        .quick-date-btn:active,
        .quick-date-btn.active {
            background-color: transparent !important;
            color: #ec3737 !important;
            border: none !important;
        }
        
        /* User filter hover styling */
        #userFilterForm .btn-outline-secondary:hover {
            background-color: #ec3737 !important;
            border-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        #userFilterForm .btn-outline-secondary:hover .text-secondary-light {
            color: #ffffff !important;
        }
        
        #userFilterForm select.form-select:hover {
            background-color: #ec3737 !important;
            border-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        /* Select dropdown options styling */
        #userFilterForm select.form-select option {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            padding: 8px 12px;
        }
        
        #userFilterForm select.form-select option:hover {
            background-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        #userFilterForm select.form-select option:checked,
        #userFilterForm select.form-select option:focus {
            background-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        /* Ensure Flatpickr calendar is visible - Match Goals Module */
        #dateRangePicker .flatpickr-calendar {
            display: block !important;
            position: relative !important;
            box-shadow: none !important;
            opacity: 1 !important;
            visibility: visible !important;
            width: auto !important;
            border: none !important;
            background: transparent !important;
        }
        
        .flatpickr-calendar.inline {
            display: block !important;
            position: relative !important;
            box-shadow: none !important;
            opacity: 1 !important;
            visibility: visible !important;
            border: none !important;
        }
        
        /* Style for two-month display */
        .flatpickr-months {
            display: flex !important;
            gap: 20px;
        }
        
        /* Month navigation */
        .flatpickr-month {
            background: transparent !important;
            color: #1f2937 !important;
            height: auto !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }
        
        .flatpickr-current-month {
            padding: 10px 0 !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: static !important;
            width: auto !important;
            transform: none !important;
            height: auto !important;
        }
        
        .flatpickr-monthDropdown-months {
            font-weight: 600 !important;
            color: #1f2937 !important;
            background: transparent !important;
            border: none !important;
        }
        
        .numInputWrapper {
            display: inline-block !important;
        }
        
        .cur-year {
            display: inline-block !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
        }
        
        .cur-year .numInput {
            display: inline-block !important;
            color: #1f2937 !important;
            font-weight: 600 !important;
        }
        
        /* Weekday headers */
        .flatpickr-weekdays {
            background: transparent !important;
            height: 40px !important;
            align-items: center !important;
        }
        
        .flatpickr-weekday {
            color: #6b7280 !important;
            font-weight: 600 !important;
            font-size: 13px !important;
        }
        
        /* Day cells */
        .flatpickr-days {
            width: auto !important;
        }
        
        .flatpickr-day {
            color: #1f2937 !important;
            border: none !important;
            border-radius: 6px !important;
            height: 36px !important;
            line-height: 36px !important;
            max-width: 36px !important;
            font-weight: 500 !important;
            margin: 2px !important;
        }
        
        .flatpickr-day:hover {
            background: #f3f4f6 !important;
            border-color: transparent !important;
        }
        
        /* Today - RED BRANDING */
        .flatpickr-day.today {
            border: 2px solid #ec3737 !important;
            color: #ec3737 !important;
            font-weight: 600 !important;
        }
        
        .flatpickr-day.today:hover {
            background: #fef2f2 !important;
            border-color: #ec3737 !important;
        }
        
        /* Selected and range - RED BRANDING */
        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #ec3737 !important;
            border-color: #ec3737 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
        }
        
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover {
            background: #d42f2f !important;
            border-color: #d42f2f !important;
        }
        
        .flatpickr-day.inRange {
            background: #fee2e2 !important;
            border-color: transparent !important;
            color: #991b1b !important;
            box-shadow: none !important;
        }
        
        /* Disabled days */
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: #d1d5db !important;
        }
        
        .flatpickr-day.flatpickr-disabled:hover {
            background: transparent !important;
            cursor: not-allowed !important;
        }
        
        /* Ensure two months display side by side */
        #dateRangePicker .flatpickr-months {
            display: flex !important;
            flex-wrap: nowrap !important;
        }
        
        /* Ensure calendar doesn't overflow */
        #dateRangePicker {
            width: 100%;
            max-width: 100%;
        }
        
        #dateRangePicker .flatpickr-calendar.inline {
            display: block !important;
            position: static !important;
            box-shadow: none !important;
            width: auto !important;
            max-width: none !important;
        }
    </style>
    @endpush

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">User Management</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Users</li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <iconify-icon icon="mdi:check-circle" class="icon text-xl me-2"></iconify-icon>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <iconify-icon icon="mdi:alert-circle" class="icon text-xl me-2"></iconify-icon>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Date Range and Filter Section -->
        <div class="card mb-24 border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('users.index') }}" id="userFilterForm">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <!-- Date Range Picker with Dropdown -->
                        <div class="dropdown">
                            <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-2 radius-8 px-16 py-11 dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" style="min-width: 280px;">
                                <iconify-icon icon="mdi:calendar" class="text-secondary-light"></iconify-icon>
                                <span id="dateRangeDisplay">
                                    {{ $dateFrom && $dateTo ? \Carbon\Carbon::parse($dateFrom)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($dateTo)->format('M d, Y') : \Carbon\Carbon::now()->startOfMonth()->format('M d, Y') . ' - ' . \Carbon\Carbon::now()->format('M d, Y') }}
                                </span>
                            </button>
                            <div class="dropdown-menu p-0" style="width: 800px; max-width: 95vw;" onclick="event.stopPropagation();">
                                <div class="d-flex">
                                    <!-- Quick Select Options -->
                                    <div style="width: 160px; border-right: 1px solid #e5e7eb; padding: 16px 12px; flex-shrink: 0;">
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="today">Today</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="yesterday">Yesterday</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="this_week">This week</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="month_to_date">Month to date</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="this_month">This month</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="last_month">Last month</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="this_quarter">This quarter</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="this_year">This year</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="year_to_date">Year to date</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="last_year">Last year</button>
                                    </div>
                                    <!-- Calendar -->
                                    <div style="flex: 1; padding: 16px; min-width: 0; overflow-x: auto;">
                                        <div id="dateRangePicker"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Role Filter -->
                        <div style="min-width: 200px;">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:shield-account" style="font-size: 20px; color: #ec3737;"></iconify-icon>
                                <select name="role" class="form-select radius-8 px-16 py-11" style="border: 1px solid #e5e7eb; min-width: 180px;">
                                    <option value="">All Roles</option>
                                    <option value="business_owner" {{ request('role') === 'business_owner' ? 'selected' : '' }}>Business Owner</option>
                                    <option value="manager" {{ request('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="accountant" {{ request('role') === 'accountant' ? 'selected' : '' }}>Accountant</option>
                                    <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div style="min-width: 200px;">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:filter" style="font-size: 20px; color: #ec3737;"></iconify-icon>
                                <select name="is_active" class="form-select radius-8 px-16 py-11" style="border: 1px solid #e5e7eb; min-width: 180px;">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="date_from" id="filter_date_from" value="{{ $dateFrom }}">
                        <input type="hidden" name="date_to" id="filter_date_to" value="{{ $dateTo }}">

                        <!-- Apply Filter Button -->
                        <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2 ms-auto" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            <iconify-icon icon="mdi:filter-check" style="font-size: 18px;"></iconify-icon>
                            <span>Apply Filter</span>
                        </button>

                        <!-- Reset Filter Button -->
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2">
                            <iconify-icon icon="mdi:refresh" style="font-size: 18px;"></iconify-icon>
                            <span>Reset</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="row gy-4 mb-24">
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-secondary-light mb-1">Total Users</p>
                                <h6 class="mb-0 fw-bold" style="color: #ec3737; font-size: 1.5rem;">{{ $users->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px rounded-circle d-flex justify-content-center align-items-center" style="background-color: #ec3737;">
                                <iconify-icon icon="mdi:account-group" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-2">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Active Users</p>
                                <h6 class="mb-0">{{ $users->where('is_active', true)->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:account-check" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-3">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Business Owners</p>
                                <h6 class="mb-0">{{ $users->where('role', 'business_owner')->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-warning-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:shield-crown" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-4">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Managers</p>
                                <h6 class="mb-0">{{ $users->where('role', 'manager')->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-info-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:account-tie" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-md mb-0 fw-semibold text-secondary-light">Show</span>
                        <select class="form-select form-select-sm w-auto" id="entries-per-page">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="icon-field">
                        <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search users..." id="search-input">
                        <span class="icon" style="color: #ec3737;">
                            <iconify-icon icon="ion:search-outline"></iconify-icon>
                        </span>
                    </div>
                </div>
                <button type="button" id="addUserBtn" class="btn text-white text-sm btn-sm px-20 py-12 radius-8 d-flex align-items-center gap-2 fw-bold shadow-sm" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    <iconify-icon icon="ic:baseline-plus" style="font-size: 18px;"></iconify-icon>
                    Add New User
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table bordered-table mb-0" id="users-table" style="min-width: 900px;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 50px;">No.</th>
                                <th scope="col" style="min-width: 150px;">User Name</th>
                                <th scope="col" style="min-width: 150px;">Email</th>
                                <th scope="col" style="min-width: 120px;">Phone</th>
                                <th scope="col" style="min-width: 100px;">Role</th>
                                <th scope="col" class="text-center" style="min-width: 80px;">Status</th>
                                <th scope="col" class="text-center" style="min-width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center">
                                    <span class="text-sm fw-medium">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="w-32-px h-32-px rounded-circle d-flex justify-content-center align-items-center text-white fw-bold" style="background-color: #ec3737; font-size: 12px;">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm fw-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $user->email }}</span>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $user->phone ?? '-' }}</span>
                                </td>
                                <td>
                                    @php
                                        $roleColors = [
                                            'business_owner' => 'danger',
                                            'manager' => 'warning',
                                            'accountant' => 'info',
                                            'staff' => 'primary'
                                        ];
                                        $color = $roleColors[$user->role] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}-100 text-{{ $color }}-600 px-12 py-6">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td class="text-center">
                                    @if($user->is_active)
                                        <span class="badge bg-success-100 text-success-600 px-12 py-6">Active</span>
                                    @else
                                        <span class="badge bg-danger-100 text-danger-600 px-12 py-6">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-6 justify-content-center">
                                        <button type="button" class="view-user-btn bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="View" data-user-id="{{ $user->id }}">
                                            <iconify-icon icon="solar:eye-linear" class="icon text-lg"></iconify-icon>
                                        </button>
                                        <button type="button" class="edit-user-btn fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle text-white border-0" style="background-color: #ec3737;" title="Edit" data-user-id="{{ $user->id }}" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                                            <iconify-icon icon="lucide:edit" class="icon text-lg"></iconify-icon>
                                        </button>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle delete-btn border-0" title="Delete">
                                                <iconify-icon icon="fluent:delete-24-regular" class="icon text-lg"></iconify-icon>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-48">
                                    <div class="d-flex flex-column align-items-center">
                                        <iconify-icon icon="mdi:account-off" class="text-secondary-light mb-8" style="font-size: 48px;"></iconify-icon>
                                        <p class="text-secondary-light mb-16">No users found</p>
                                        <button type="button" id="addFirstUserBtn" class="btn text-white px-20 py-11 radius-8" style="background-color: #ec3737;">
                                            <iconify-icon icon="ic:baseline-plus" class="icon text-xl me-1"></iconify-icon>
                                            Add Your First User
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" id="addUserModalLabel" style="font-size: 18px !important;">
                        Add New User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="addUserModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" id="editUserModalLabel" style="font-size: 18px !important;">
                        Edit User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editUserModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" id="viewUserModalLabel" style="font-size: 18px !important;">
                        User Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Basic Information Section -->
                    <div class="mb-24">
                        <div class="d-flex align-items-center gap-2 mb-20">
                            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                <iconify-icon icon="mdi:information-outline" class="text-white" style="font-size: 16px;"></iconify-icon>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Basic Information</h6>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fef2f2; border-radius: 8px; flex-shrink: 0;">
                                        <iconify-icon icon="mdi:account" style="color: #ec3737; font-size: 20px;"></iconify-icon>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1" style="font-size: 12px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Full Name</p>
                                        <p class="mb-0" style="font-size: 15px; font-weight: 600; color: #111827;" id="view_name">-</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fef2f2; border-radius: 8px; flex-shrink: 0;">
                                        <iconify-icon icon="mdi:email" style="color: #ec3737; font-size: 20px;"></iconify-icon>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1" style="font-size: 12px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Email Address</p>
                                        <p class="mb-0" style="font-size: 15px; font-weight: 600; color: #111827; word-break: break-all;" id="view_email">-</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fef2f2; border-radius: 8px; flex-shrink: 0;">
                                        <iconify-icon icon="mdi:phone" style="color: #ec3737; font-size: 20px;"></iconify-icon>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1" style="font-size: 12px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Phone Number</p>
                                        <p class="mb-0" style="font-size: 15px; font-weight: 600; color: #111827;" id="view_phone">-</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fef2f2; border-radius: 8px; flex-shrink: 0;">
                                        <iconify-icon icon="mdi:shield-account" style="color: #ec3737; font-size: 20px;"></iconify-icon>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1" style="font-size: 12px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">User Role</p>
                                        <div id="view_role">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Module Permissions Section -->
                    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;" id="view_permissions_section">
                        <div class="d-flex align-items-center gap-2 mb-16">
                            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                <iconify-icon icon="mdi:shield-account-outline" class="text-white" style="font-size: 16px;"></iconify-icon>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Module Permissions</h6>
                        </div>
                        
                        <div class="row" id="view_permissions_list">
                            <div class="col-12">
                                <p class="text-muted text-center py-3">Loading permissions...</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account Status Section -->
                    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
                        <div class="d-flex align-items-center gap-2 mb-16">
                            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                <iconify-icon icon="mdi:tune-variant" class="text-white" style="font-size: 16px;"></iconify-icon>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Account Status</h6>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-16 rounded-3" style="background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%); border: 1px solid #e5e7eb;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="text-secondary-light mb-4" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Status</p>
                                            <span id="view_status">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-16 rounded-3" style="background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%); border: 1px solid #e5e7eb;">
                                    <div>
                                        <p class="text-secondary-light mb-4" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Joined Date</p>
                                        <p class="fw-semibold mb-0" style="color: #1f2937; font-size: 15px;" id="view_created_at">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top" style="padding: 20px 24px;">
                    <button type="button" class="btn btn-outline-secondary radius-8 d-flex align-items-center gap-2" style="padding: 11px 24px; font-size: 14px; font-weight: 500;" data-bs-dismiss="modal">
                        <iconify-icon icon="mdi:close" style="font-size: 18px;"></iconify-icon>
                        <span>Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Flatpickr JS -->
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Flatpickr for inline calendar
            let userDateRangePicker = null;
            const dropdownButton = $('#userFilterForm .dropdown-toggle[data-bs-toggle="dropdown"]').first();
            
            // Initialize Flatpickr when dropdown is opened
            dropdownButton.on('click', function() {
                setTimeout(function() {
                    if (!userDateRangePicker) {
                        console.log('Initializing User Date Range Picker...');
                        
                        const calendarElement = document.getElementById('dateRangePicker');
                        if (calendarElement && typeof flatpickr !== 'undefined') {
                            userDateRangePicker = flatpickr(calendarElement, {
                                mode: "range",
                                inline: true,
                                showMonths: 2,
                                dateFormat: "Y-m-d",
                                defaultDate: ['{{ $dateFrom }}', '{{ $dateTo }}'],
                                onChange: function(selectedDates, dateStr, instance) {
                                    console.log('User dates selected:', selectedDates);
                                    if (selectedDates.length === 2) {
                                        updateUserDateRange(selectedDates[0], selectedDates[1]);
                                    }
                                },
                                onReady: function() {
                                    console.log('User Flatpickr ready with', this.config.showMonths, 'months!');
                                }
                            });
                            
                            console.log('User Flatpickr instance created:', userDateRangePicker);
                        } else {
                            console.error('Cannot initialize User Flatpickr:', {
                                element: calendarElement,
                                flatpickrAvailable: typeof flatpickr !== 'undefined'
                            });
                        }
                    }
                }, 100);
            });

            // Quick date range selection
            $('.quick-date-btn').on('click', function() {
                const range = $(this).data('range');
                const dates = getUserDateRange(range);
                
                $('.quick-date-btn').removeClass('active');
                $(this).addClass('active');
                
                if (userDateRangePicker) {
                    userDateRangePicker.setDate([dates.from, dates.to]);
                }
                updateUserDateRange(dates.from, dates.to);
            });

            function getUserDateRange(range) {
                const today = new Date();
                let from, to;

                switch(range) {
                    case 'today':
                        from = to = new Date();
                        break;
                    case 'yesterday':
                        from = to = new Date(today.setDate(today.getDate() - 1));
                        break;
                    case 'this_week':
                        from = new Date(today.setDate(today.getDate() - today.getDay()));
                        to = new Date();
                        break;
                    case 'month_to_date':
                    case 'this_month':
                        from = new Date(today.getFullYear(), today.getMonth(), 1);
                        to = new Date();
                        break;
                    case 'last_month':
                        from = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        to = new Date(today.getFullYear(), today.getMonth(), 0);
                        break;
                    case 'this_quarter':
                        const quarter = Math.floor(today.getMonth() / 3);
                        from = new Date(today.getFullYear(), quarter * 3, 1);
                        to = new Date(today.getFullYear(), (quarter + 1) * 3, 0);
                        break;
                    case 'this_year':
                        from = new Date(today.getFullYear(), 0, 1);
                        to = new Date(today.getFullYear(), 11, 31);
                        break;
                    case 'year_to_date':
                        from = new Date(today.getFullYear(), 0, 1);
                        to = new Date();
                        break;
                    case 'last_year':
                        from = new Date(today.getFullYear() - 1, 0, 1);
                        to = new Date(today.getFullYear() - 1, 11, 31);
                        break;
                }

                return { from, to };
            }

            function updateUserDateRange(from, to) {
                const fromDate = from instanceof Date ? from : new Date(from);
                const toDate = to instanceof Date ? to : new Date(to);
                
                // Format dates for display
                const options = { year: 'numeric', month: 'short', day: 'numeric' };
                const fromStr = fromDate.toLocaleDateString('en-US', options);
                const toStr = toDate.toLocaleDateString('en-US', options);
                
                // Update display
                $('#dateRangeDisplay').text(fromStr + ' - ' + toStr);
                
                // Update hidden inputs
                $('#filter_date_from').val(formatUserDate(fromDate));
                $('#filter_date_to').val(formatUserDate(toDate));
            }

            function formatUserDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Initialize DataTable
            if ($.fn.DataTable.isDataTable("#users-table")) {
                $("#users-table").DataTable().destroy();
            }

            var table = $("#users-table").DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "responsive": true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthChange": false,
                "dom": '<"top">rt<"bottom"p><"clear">',
                "language": {
                    "emptyTable": "No users available",
                    "zeroRecords": "No matching users found",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": '<iconify-icon icon="ic:baseline-chevron-right"></iconify-icon>',
                        "previous": '<iconify-icon icon="ic:baseline-chevron-left"></iconify-icon>'
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": [0, -1] }
                ],
                "order": [[1, "asc"]]
            });

            // Custom search
            $("#search-input").on("keyup", function() {
                table.search(this.value).draw();
            });

            // Custom page length
            $("#entries-per-page").on("change", function() {
                table.page.len(parseInt(this.value)).draw();
            });

            // Open Add User Modal
            $("#addUserBtn, #addFirstUserBtn").on("click", function() {
                $('#addUserModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                $("#addUserModal").modal("show");
                
                $.ajax({
                    url: '{{ route("users.create") }}',
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        $('#addUserModalBody').html(response);
                    },
                    error: function(xhr) {
                        $('#addUserModalBody').html('<div class="alert alert-danger">Error loading form. Please try again.</div>');
                    }
                });
            });

            // Handle add user form submission
            $(document).on('submit', '#addUserForm', function(e) {
                e.preventDefault();
                
                const form = $(this);
                const formData = form.serialize();
                const submitBtn = form.find('button[type="submit"]');
                const originalBtnText = submitBtn.html();
                
                // Clear previous errors
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();
                
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Creating...');
                
                $.ajax({
                    url: '{{ route("users.store") }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#addUserModal').modal('hide');
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                const input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to create user. Please try again.'
                            });
                        }
                    }
                });
            });

            // Open Edit User Modal
            $(document).on("click", ".edit-user-btn", function() {
                const userId = $(this).data("user-id");
                
                $('#editUserModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                $('#editUserModal').modal('show');
                
                $.ajax({
                    url: '/users/' + userId + '/edit',
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        // Load the edit form partial
                        $.ajax({
                            url: '/users/partials/edit-form',
                            method: 'GET',
                            data: { user: response.user },
                            success: function(formHtml) {
                                $('#editUserModalBody').html(formHtml);
                                
                                // Populate form
                                $('#edit_user_id').val(response.user.id);
                                $('#edit_name').val(response.user.name);
                                $('#edit_email').val(response.user.email);
                                $('#edit_phone').val(response.user.phone || '');
                                $('#edit_role').val(response.user.role);
                                $('#edit_is_active').prop('checked', response.user.is_active);
                                
                                // Populate permissions
                                $('.edit-permission-checkbox').prop('checked', false);
                                if (response.user.permissions && Array.isArray(response.user.permissions)) {
                                    response.user.permissions.forEach(function(permission) {
                                        $('#edit_permission_' + permission).prop('checked', true);
                                    });
                                }
                                
                                // Trigger role change to show/hide permissions section
                                $('#edit_role').trigger('change');
                            }
                        });
                    },
                    error: function(xhr) {
                        $('#editUserModal').modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load user data.'
                        });
                    }
                });
            });

            // Handle edit user form submission
            $(document).on('submit', '#editUserForm', function(e) {
                e.preventDefault();
                
                const form = $(this);
                const userId = $('#edit_user_id').val();
                const formData = form.serialize();
                const submitBtn = form.find('button[type="submit"]');
                const originalBtnText = submitBtn.html();
                
                // Clear previous errors
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();
                
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');
                
                $.ajax({
                    url: '/users/' + userId,
                    method: 'PUT',
                    data: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#editUserModal').modal('hide');
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                const input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to update user. Please try again.'
                            });
                        }
                    }
                });
            });

            // Open View User Modal
            $(document).on("click", ".view-user-btn", function() {
                const userId = $(this).data("user-id");
                
                $("#viewUserModal").modal("show");

                $.ajax({
                    url: "/users/" + userId,
                    method: "GET",
                    headers: {
                        "Accept": "application/json"
                    },
                    success: function(response) {
                        const user = response.user;
                        
                        // Basic Information
                        $("#view_name").text(user.name);
                        $("#view_email").text(user.email);
                        $("#view_phone").text(user.phone || "Not Provided");
                        
                        // Role badge with new styling
                        const roleLabels = {
                            'super_admin': 'Super Admin',
                            'business_owner': 'Business Owner',
                            'manager': 'Manager',
                            'accountant': 'Accountant',
                            'staff': 'Staff'
                        };
                        const roleColors = {
                            'super_admin': { bg: '#fee2e2', text: '#991b1b' },
                            'business_owner': { bg: '#fef3c7', text: '#92400e' },
                            'manager': { bg: '#fef3c7', text: '#92400e' },
                            'accountant': { bg: '#dbeafe', text: '#1e40af' },
                            'staff': { bg: '#e5e7eb', text: '#374151' }
                        };
                        
                        const roleLabel = roleLabels[user.role] || user.role.charAt(0).toUpperCase() + user.role.slice(1);
                        const colors = roleColors[user.role] || { bg: '#e5e7eb', text: '#374151' };
                        
                        $("#view_role").html(`<span class="badge px-12 py-6 fw-semibold" style="background-color: ${colors.bg}; color: ${colors.text};">${roleLabel}</span>`);
                        
                        // Status badge with larger style
                        if (user.is_active) {
                            $("#view_status").html('<span class="badge px-16 py-8 fw-semibold" style="background-color: #d1fae5; color: #065f46; font-size: 14px;">Active</span>');
                        } else {
                            $("#view_status").html('<span class="badge px-16 py-8 fw-semibold" style="background-color: #fee2e2; color: #991b1b; font-size: 14px;">Inactive</span>');
                        }
                        
                        // Module Permissions
                        const moduleLabels = {
                            'dashboard': 'Dashboard',
                            'products': 'Products',
                            'stock': 'Stock Management',
                            'sales': 'Sales',
                            'invoices': 'Invoices',
                            'customers': 'Customers',
                            'expenses': 'Expenses',
                            'reports': 'Reports',
                            'goals': 'Target Goals',
                            'users': 'User Management'
                        };
                        
                        let permissionsHtml = '';
                        
                        if (user.role === 'business_owner' || user.role === 'super_admin') {
                            permissionsHtml = '<div class="col-12"><div class="alert alert-info mb-0" style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b;"><iconify-icon icon="mdi:information" class="me-2"></iconify-icon>This user has full access to all modules.</div></div>';
                        } else if (user.permissions && user.permissions.length > 0) {
                            user.permissions.forEach(function(permission) {
                                const label = moduleLabels[permission] || permission;
                                permissionsHtml += `
                                    <div class="col-md-6 mb-12">
                                        <div class="p-12 rounded-2 d-flex align-items-center gap-2" style="background-color: #fef2f2; border: 1px solid #fecaca;">
                                            <iconify-icon icon="mdi:check-circle" style="color: #ec3737; font-size: 18px;"></iconify-icon>
                                            <span class="fw-medium" style="color: #991b1b; font-size: 14px;">${label}</span>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            permissionsHtml = '<div class="col-12"><div class="alert alert-warning mb-0" style="background-color: #fef3c7; border: 1px solid #fde047; color: #92400e;"><iconify-icon icon="mdi:alert" class="me-2"></iconify-icon>No module permissions assigned.</div></div>';
                        }
                        
                        $("#view_permissions_list").html(permissionsHtml);
                        
                        // Hide permissions section for admin roles
                        if (user.role === 'business_owner' || user.role === 'super_admin') {
                            $("#view_permissions_section").hide();
                        } else {
                            $("#view_permissions_section").show();
                        }
                        
                        // Created date
                        const createdDate = new Date(user.created_at);
                        $("#view_created_at").text(createdDate.toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        }));
                    },
                    error: function(xhr) {
                        $("#viewUserModal").modal("hide");
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "Failed to load user details."
                        });
                    }
                });
            });

            // Delete confirmation
            $(document).on("click", ".delete-btn", function(e) {
                e.preventDefault();
                var form = $(this).closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This user will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ec3737",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $(".alert").fadeOut("slow");
            }, 5000);
        });
    </script>
    @endpush

</x-layout.master>

