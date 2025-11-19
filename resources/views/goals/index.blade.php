<x-layout.master>

    @push('styles')
    <style>
        /* Ensure Flatpickr calendar is visible */
        #dateRangeCalendar .flatpickr-calendar {
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
        
        /* Today */
        .flatpickr-day.today {
            border: 2px solid #ec3737 !important;
            color: #ec3737 !important;
            font-weight: 600 !important;
        }
        
        .flatpickr-day.today:hover {
            background: #fef2f2 !important;
            border-color: #ec3737 !important;
        }
        
        /* Selected and range */
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
        
        /* Navigation arrows */
        .flatpickr-prev-month,
        .flatpickr-next-month {
            fill: #6b7280 !important;
            position: static !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 5px !important;
        }
        
        .flatpickr-prev-month svg,
        .flatpickr-next-month svg {
            fill: #6b7280 !important;
            width: 14px !important;
            height: 14px !important;
        }
        
        .flatpickr-prev-month:hover,
        .flatpickr-next-month:hover {
            fill: #ec3737 !important;
        }
        
        .flatpickr-prev-month:hover svg,
        .flatpickr-next-month:hover svg {
            fill: #ec3737 !important;
        }
        
        /* Ensure dropdown shows properly */
        .dropdown-menu {
            max-height: none !important;
        }
        
        /* Fix Flatpickr inline calendar display */
        #dateRangeCalendar .flatpickr-calendar.inline {
            display: block !important;
            position: static !important;
            box-shadow: none !important;
            width: auto !important;
            max-width: none !important;
        }
        
        /* Ensure two months display side by side */
        #dateRangeCalendar .flatpickr-months {
            display: flex !important;
            flex-wrap: nowrap !important;
        }
        
        /* Ensure calendar doesn't overflow */
        #dateRangeCalendar {
            width: 100%;
            max-width: 100%;
        }
        
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
        
        /* Goal module filter hover styling */
        #goalFilterForm .btn-outline-secondary:hover {
            background-color: #ec3737 !important;
            border-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        #goalFilterForm .btn-outline-secondary:hover .text-secondary-light {
            color: #ffffff !important;
        }
        
        #goalFilterForm select.form-select:hover {
            background-color: #ec3737 !important;
            border-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        /* Select dropdown options styling */
        #goalFilterForm select.form-select option {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            padding: 8px 12px;
        }
        
        #goalFilterForm select.form-select option:hover {
            background-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        #goalFilterForm select.form-select option:checked,
        #goalFilterForm select.form-select option:focus {
            background-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        /* Goal Action Menu Styling */
        .goal-action-menu {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        }
        
        .goal-menu-item:hover {
            background-color: #f9fafb !important;
        }
        
        .goal-menu-item:hover i {
            color: #1f2937 !important;
        }
        
        .goal-menu-delete:hover {
            background-color: #fef2f2 !important;
        }
        
        .goal-menu-delete:hover i {
            color: #dc2626 !important;
        }
        
        .goal-menu-delete:hover span {
            color: #dc2626 !important;
        }
    </style>
    @endpush

    <div class="dashboard-main-body">
        
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-24 d-flex align-items-center" role="alert">
            <i class="bi bi-circle-fill"></i>
            <span class="flex-grow-1">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-24 d-flex align-items-center" role="alert">
            <i class="bi bi-circle-fill"></i>
            <span class="flex-grow-1">{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Target Goals</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Target Goals</li>
            </ul>
        </div>

        <!-- Date Range and Status Filter -->
        <div class="card mb-24 border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('goals.index') }}" id="goalFilterForm">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <!-- Date Range Picker with Dropdown -->
                        <div class="dropdown">
                            <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-2 radius-8 px-16 py-11 dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" style="min-width: 280px;">
                                <i class="bi bi-circle-fill"></i>
                                <span id="dateRangeDisplay">
                                    {{ request('date_from') && request('date_to') ? \Carbon\Carbon::parse(request('date_from'))->format('M d, Y') . ' - ' . \Carbon\Carbon::parse(request('date_to'))->format('M d, Y') : \Carbon\Carbon::now()->startOfMonth()->format('M d, Y') . ' - ' . \Carbon\Carbon::now()->format('M d, Y') }}
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
                                        <div id="dateRangeCalendar"></div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="date_from" id="date_from" value="{{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}">
                            <input type="hidden" name="date_to" id="date_to" value="{{ request('date_to', now()->format('Y-m-d')) }}">
                        </div>

                        <!-- Status Filter Dropdown -->
                        <select name="filter" class="form-select radius-8" style="width: auto; min-width: 180px;" onchange="document.getElementById('goalFilterForm').submit()">
                            <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>STATUS: All Goals</option>
                            <option value="active" {{ $filter === 'active' ? 'selected' : '' }}>STATUS: Active</option>
                            <option value="upcoming" {{ $filter === 'upcoming' ? 'selected' : '' }}>STATUS: Upcoming</option>
                            <option value="completed" {{ $filter === 'completed' ? 'selected' : '' }}>STATUS: Completed</option>
                        </select>

                        <!-- Refresh Button -->
                        <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" onclick="refreshAllGoals()">
                            <i class="bi bi-circle-fill"></i>
                            Refresh
                        </button>

                        <!-- Create Goal Button -->
                        <button type="button" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2 ms-auto" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'" data-bs-toggle="modal" data-bs-target="#createGoalModal">
                            <i class="bi bi-circle-fill"></i>
                            Create Goal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="row gy-4 mb-24">
            <div class="col-xxl-12">
                <div class="row gy-4">
                    <!-- Active Goals -->
                    <div class="col-xxl-3 col-sm-6">
                        <div class="card p-3 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%); border-left: 4px solid #06b6d4 !important;">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #06b6d4;">
                                            <i class="bi bi-circle-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Active Goals</span>
                                            <h6 class="fw-bold" style="color: #06b6d4;">{{ $activeGoals }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Status <span class="px-1 rounded-2 fw-bold text-white text-sm" style="background-color: #06b6d4;">In Progress</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- On Track -->
                    <div class="col-xxl-3 col-sm-6">
                        <div class="card p-3 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); border-left: 4px solid #10b981 !important;">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #10b981;">
                                            <i class="bi bi-circle-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">On Track</span>
                                            <h6 class="fw-bold" style="color: #10b981;">{{ $onTrackGoals }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Performance <span class="px-1 rounded-2 fw-bold text-white text-sm" style="background-color: #10b981;">Excellent</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- At Risk -->
                    <div class="col-xxl-3 col-sm-6">
                        <div class="card p-3 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%); border-left: 4px solid #f59e0b !important;">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #f59e0b;">
                                            <i class="bi bi-circle-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">At Risk</span>
                                            <h6 class="fw-bold" style="color: #f59e0b;">{{ $atRiskGoals }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Status <span class="px-1 rounded-2 fw-bold text-white text-sm" style="background-color: #f59e0b;">Needs Attention</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Completed -->
                    <div class="col-xxl-3 col-sm-6">
                        <div class="card p-3 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #faf5ff 0%, #ffffff 100%); border-left: 4px solid #a855f7 !important;">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #a855f7;">
                                            <i class="bi bi-circle-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Completed</span>
                                            <h6 class="fw-bold" style="color: #a855f7;">{{ $completedGoals }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Status <span class="px-1 rounded-2 fw-bold text-white text-sm" style="background-color: #a855f7;">Achieved</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Goals Grid -->
        <div class="row gy-4">
            @forelse($goals as $goal)
            <div class="col-lg-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <!-- Goal Header -->
                        <div class="d-flex align-items-start justify-content-between mb-16">
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-8">{{ $goal->name }}</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-{{ $goal->status_color }}-100 text-{{ $goal->status_color }}-600 px-12 py-4">
                                        {{ ucfirst($goal->status) }}
                                    </span>
                                    <span class="badge bg-neutral-200 text-neutral-600 px-12 py-4">
                                        {{ $goal->getGoalTypeLabel() }}
                                    </span>
                                    @if($goal->priority === 'high')
                                    <span class="badge bg-danger-100 text-danger-600 px-12 py-4 d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-circle-fill"></i>
                                        <span>High Priority</span>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light radius-8" type="button" data-bs-toggle="dropdown" style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-circle-fill"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 goal-action-menu" style="min-width: 160px; border-radius: 12px; overflow: hidden; margin-top: 8px;">
                                    <li>
                                        <a class="dropdown-item goal-menu-item edit-goal-btn" href="javascript:void(0);" data-goal-id="{{ $goal->id }}" style="padding: 12px 16px; display: flex; align-items-center; gap: 10px; transition: all 0.2s ease; cursor: pointer;">
                                            <i class="bi bi-circle-fill"></i>
                                            <span style="font-weight: 500;">Edit</span>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider" style="margin: 4px 0; border-color: #f3f4f6;"></li>
                                    <li>
                                        <form action="{{ route('goals.destroy', $goal) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this goal?');" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item goal-menu-item goal-menu-delete" style="padding: 12px 16px; display: flex; align-items: center; gap: 10px; width: 100%; border: none; background: none; text-align: left; transition: all 0.2s ease;">
                                                <i class="bi bi-circle-fill"></i>
                                                <span style="font-weight: 500; color: #ef4444;">Delete</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Progress Circle -->
                        <div class="text-center my-20">
                            <div class="progress-circle mx-auto" style="width: 120px; height: 120px;">
                                <svg width="120" height="120">
                                    <circle cx="60" cy="60" r="54" fill="none" stroke="#e9ecef" stroke-width="8"></circle>
                                    <circle cx="60" cy="60" r="54" fill="none" 
                                            stroke="{{ $goal->isOnTrack() ? '#10b981' : ($goal->progress_percentage >= 100 ? '#10b981' : '#f59e0b') }}" 
                                            stroke-width="8" 
                                            stroke-dasharray="{{ 2 * pi() * 54 }}" 
                                            stroke-dashoffset="{{ 2 * pi() * 54 * (1 - min($goal->progress_percentage, 100) / 100) }}"
                                            stroke-linecap="round"
                                            transform="rotate(-90 60 60)">
                                    </circle>
                                    <text x="60" y="60" text-anchor="middle" dy="7" font-size="24" font-weight="bold" fill="#333">
                                        {{ number_format($goal->progress_percentage, 0) }}%
                                    </text>
                                </svg>
                            </div>
                        </div>

                        <!-- Progress Details -->
                        <div class="mb-16">
                            <div class="d-flex justify-content-between text-sm mb-8">
                                <span class="text-secondary-light">Current:</span>
                                <span class="fw-semibold">
                                    @if(in_array($goal->goal_type, ['profit_margin']))
                                        {{ number_format($goal->current_amount, 2) }}%
                                    @else
                                        {{ auth()->user()->business->currency }} {{ number_format($goal->current_amount, 2) }}
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between text-sm mb-8">
                                <span class="text-secondary-light">Target:</span>
                                <span class="fw-semibold">
                                    @if(in_array($goal->goal_type, ['profit_margin']))
                                        {{ number_format($goal->target_amount, 2) }}%
                                    @else
                                        {{ auth()->user()->business->currency }} {{ number_format($goal->target_amount, 2) }}
                                    @endif
                                </span>
                            </div>
                            @if($goal->current_amount >= $goal->target_amount)
                            <div class="text-center mt-12">
                                <span class="badge bg-success-100 text-success-600 px-16 py-8 d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Goal Achieved! 🎉</span>
                                </span>
                            </div>
                            @else
                            <div class="d-flex justify-content-between text-sm">
                                <span class="text-secondary-light">Remaining:</span>
                                <span class="fw-semibold text-danger-600">
                                    @if(in_array($goal->goal_type, ['profit_margin']))
                                        {{ number_format($goal->target_amount - $goal->current_amount, 2) }}%
                                    @else
                                        {{ auth()->user()->business->currency }} {{ number_format($goal->target_amount - $goal->current_amount, 2) }}
                                    @endif
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Time Period -->
                        <div class="border-top pt-16">
                            <div class="d-flex align-items-center justify-content-between text-sm">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-circle-fill"></i>
                                    <span class="text-secondary-light">
                                        {{ $goal->start_date->format('M d, Y') }} - {{ $goal->end_date->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                            @if($goal->isActive())
                            <div class="d-flex align-items-center justify-content-between text-sm mt-8">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-circle-fill"></i>
                                    <span class="text-secondary-light">
                                        {{ $goal->getDaysRemaining() }} days remaining
                                    </span>
                                </div>
                                @if(!$goal->isOnTrack())
                                <span class="badge bg-warning-100 text-warning-600 px-8 py-4">
                                    Behind Pace
                                </span>
                                @else
                                <span class="badge bg-success-100 text-success-600 px-8 py-4">
                                    On Track
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-80">
                        <div class="d-flex justify-content-center mb-16">
                            <i class="bi bi-circle-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-8">No Goals Found</h5>
                        <p class="text-secondary-light mb-0">Start tracking your business goals and measure your progress.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Create Goal Modal -->
        <div class="modal fade" id="createGoalModal" tabindex="-1" aria-labelledby="createGoalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                        <h5 class="modal-title text-white fw-bold" id="createGoalModalLabel" style="font-size: 18px !important;">
                            <i class="bi bi-circle-fill"></i>
                            Create New Goal
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="createGoalModalBody">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Goal Modal -->
        <div class="modal fade" id="editGoalModal" tabindex="-1" aria-labelledby="editGoalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                        <h5 class="modal-title text-white fw-bold" id="editGoalModalLabel" style="font-size: 18px !important;">
                            Edit Goal
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="editGoalModalBody">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Flatpickr JS (using local) -->
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    
    <script>
        // Initialize Date Range Picker
        $(document).ready(function() {
            let dateRangePicker = null;
            
            // Get the dropdown button
            const dropdownButton = $('.dropdown-toggle[data-bs-toggle="dropdown"]').first();
            
            // Initialize Flatpickr when dropdown is clicked/opened
            dropdownButton.on('click', function() {
                // Small delay to ensure dropdown is visible
                setTimeout(function() {
                    if (!dateRangePicker) {
                        console.log('Initializing Flatpickr...');
                        
                        const calendarElement = document.getElementById('dateRangeCalendar');
                        if (calendarElement && typeof flatpickr !== 'undefined') {
                            dateRangePicker = flatpickr(calendarElement, {
                                mode: "range",
                                inline: true,
                                showMonths: 2,
                                dateFormat: "Y-m-d",
                                defaultDate: [
                                    "{{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}", 
                                    "{{ request('date_to', now()->format('Y-m-d')) }}"
                                ],
                                onChange: function(selectedDates, dateStr, instance) {
                                    console.log('Dates selected:', selectedDates);
                                    if (selectedDates.length === 2) {
                                        updateDateRange(selectedDates[0], selectedDates[1]);
                                        // Close dropdown after selecting both dates
                                        setTimeout(function() {
                                            dropdownButton.dropdown('hide');
                                        }, 300);
                                    }
                                },
                                onReady: function() {
                                    console.log('Flatpickr ready with', this.config.showMonths, 'months!');
                                }
                            });
                            
                            console.log('Flatpickr instance created:', dateRangePicker);
                        } else {
                            console.error('Cannot initialize Flatpickr:', {
                                element: calendarElement,
                                flatpickrAvailable: typeof flatpickr !== 'undefined'
                            });
                        }
                    }
                }, 100);
            });

            // Quick date range buttons
            document.querySelectorAll('.quick-date-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const range = this.getAttribute('data-range');
                    const dates = getDateRange(range);
                    
                    if (dateRangePicker) {
                        dateRangePicker.setDate([dates.from, dates.to]);
                    }
                    updateDateRange(dates.from, dates.to);
                });
            });

            function getDateRange(range) {
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
                    case 'last_week':
                        to = new Date(today.setDate(today.getDate() - today.getDay() - 1));
                        from = new Date(to);
                        from.setDate(to.getDate() - 6);
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
                    case 'quarter_to_date':
                    case 'this_quarter':
                        const quarter = Math.floor(today.getMonth() / 3);
                        from = new Date(today.getFullYear(), quarter * 3, 1);
                        to = new Date();
                        break;
                    case 'last_quarter':
                        const lastQuarter = Math.floor(today.getMonth() / 3) - 1;
                        from = new Date(today.getFullYear(), lastQuarter * 3, 1);
                        to = new Date(today.getFullYear(), (lastQuarter + 1) * 3, 0);
                        break;
                    case 'year_to_date':
                    case 'this_year':
                        from = new Date(today.getFullYear(), 0, 1);
                        to = new Date();
                        break;
                    case 'last_year':
                        from = new Date(today.getFullYear() - 1, 0, 1);
                        to = new Date(today.getFullYear() - 1, 11, 31);
                        break;
                    case 'last_12_months':
                        from = new Date(today.getFullYear(), today.getMonth() - 11, 1);
                        to = new Date();
                        break;
                    default:
                        from = new Date(today.getFullYear(), today.getMonth(), 1);
                        to = new Date();
                }

                return { from, to };
            }

            function updateDateRange(from, to) {
                const fromDate = from instanceof Date ? from : new Date(from);
                const toDate = to instanceof Date ? to : new Date(to);
                
                // Format dates
                const options = { year: 'numeric', month: 'short', day: 'numeric' };
                const fromStr = fromDate.toLocaleDateString('en-US', options);
                const toStr = toDate.toLocaleDateString('en-US', options);
                
                // Update display
                document.getElementById('dateRangeDisplay').textContent = fromStr + ' - ' + toStr;
                
                // Update hidden inputs
                document.getElementById('date_from').value = formatDate(fromDate);
                document.getElementById('date_to').value = formatDate(toDate);
                
                // Submit form
                document.getElementById('goalFilterForm').submit();
            }

            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
        });

        function refreshAllGoals() {
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-circle-fill"></i> Refreshing...';
            
            fetch('{{ route("goals.refresh-all") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'All goals have been refreshed.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to refresh goals. Please try again.'
                });
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }

        // Load create goal form when modal opens
        $('#createGoalModal').on('show.bs.modal', function() {
            $('#createGoalModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            
            $.ajax({
                url: '{{ route("goals.create") }}',
                type: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#createGoalModalBody').html(response);
                    
                    // Initialize date range picker using global utility
                    setTimeout(function() {
                        initDateRangePicker({
                            inputSelector: '#create_date_range',
                            startDateInputId: 'create_start_date',
                            endDateInputId: 'create_end_date'
                        });
                    }, 100);
                },
                error: function(xhr) {
                    $('#createGoalModalBody').html('<div class="alert alert-danger">Error loading form. Please try again.</div>');
                }
            });
        });

        // Load edit goal form when edit button is clicked
        $(document).on('click', '.edit-goal-btn', function() {
            const goalId = $(this).data('goal-id');
            $('#editGoalModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            $('#editGoalModal').modal('show');
            
            $.ajax({
                url: '/goals/' + goalId + '/edit',
                type: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#editGoalModalBody').html(response);
                    
                    // Initialize date range picker using global utility
                    setTimeout(function() {
                        // Get existing dates from hidden inputs
                        const startDate = document.getElementById('edit_start_date').value;
                        const endDate = document.getElementById('edit_end_date').value;
                        
                        initDateRangePicker({
                            inputSelector: '#edit_date_range',
                            startDateInputId: 'edit_start_date',
                            endDateInputId: 'edit_end_date',
                            defaultDates: [startDate, endDate]
                        });
                    }, 100);
                },
                error: function(xhr) {
                    $('#editGoalModalBody').html('<div class="alert alert-danger">Error loading form. Please try again.</div>');
                }
            });
        });

        // Handle create goal form submission
        $(document).on('submit', '#createGoalForm', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.html();
            
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Creating...');
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#createGoalModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        errorHtml += '</ul></div>';
                        form.prepend(errorHtml);
                    } else {
                        form.prepend('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                    }
                }
            });
        });

        // Handle edit goal form submission
        $(document).on('submit', '#editGoalForm', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.html();
            
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#editGoalModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        errorHtml += '</ul></div>';
                        form.prepend(errorHtml);
                    } else {
                        form.prepend('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                    }
                }
            });
        });
    </script>
    @endpush

</x-layout.master>

