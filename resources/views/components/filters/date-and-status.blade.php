@props([
    'formAction' => '',
    'formId' => 'filterForm',
    'dateFrom' => request('date_from', now()->startOfMonth()->format('Y-m-d')),
    'dateTo' => request('date_to', now()->format('Y-m-d')),
    'statusFilter' => request('filter', 'all'),
    'statusOptions' => [
        ['value' => 'all', 'label' => 'All'],
        ['value' => 'active', 'label' => 'Active'],
        ['value' => 'upcoming', 'label' => 'Upcoming'],
        ['value' => 'completed', 'label' => 'Completed']
    ],
    'showRefreshButton' => true,
    'refreshUrl' => '',
    'refreshMethod' => 'POST',
    'showCreateButton' => false,
    'createButtonText' => 'Create',
    'createButtonModal' => '',
    'createButtonIcon' => 'bi-plus-circle',
    'totalCount' => 0,
    'moduleLabel' => 'Items'
])

@push('styles')
<style>
    /* Ensure Flatpickr calendar is visible */
    #dateRangeCalendar_{{ $formId }} .flatpickr-calendar {
        display: block !important;
        position: relative !important;
        box-shadow: none !important;
        opacity: 1 !important;
        visibility: visible !important;
        width: auto !important;
        border: none !important;
        background-color: #ffffff !important;
    }
    
    .flatpickr-calendar.inline {
        display: block !important;
        position: relative !important;
        box-shadow: none !important;
        opacity: 1 !important;
        visibility: visible !important;
        border: none !important;
        background-color: #ffffff !important;
    }
    
    /* Style for two-month display */
    .flatpickr-months {
        display: flex !important;
        gap: 16px;
        background-color: #ffffff !important;
        padding: 12px 12px 8px 12px !important;
    }
    
    /* Month navigation */
    .flatpickr-month {
        background: #ffffff !important;
        color: #1f2937 !important;
        height: auto !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }
    
    .flatpickr-current-month {
        padding: 10px 0 !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #1f2937 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        position: static !important;
        width: auto !important;
        transform: none !important;
        height: auto !important;
        background: transparent !important;
    }
    
    .flatpickr-months .flatpickr-month {
        background-color: #ffffff !important;
        padding: 4px 0 !important;
    }
    
    .flatpickr-months .flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month {
        background-color: transparent !important;
    }
    
    .flatpickr-monthDropdown-months {
        font-weight: 600 !important;
        font-size: 14px !important;
        color: #1f2937 !important;
        background: transparent !important;
        border: none !important;
    }
    
    .numInputWrapper {
        display: inline-block !important;
        background: transparent !important;
    }
    
    .cur-year {
        display: inline-block !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        color: #1f2937 !important;
        background: transparent !important;
    }
    
    .cur-year .numInput {
        display: inline-block !important;
        color: #1f2937 !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        background: transparent !important;
    }
    
    /* Weekday headers */
    .flatpickr-weekdays {
        background: transparent !important;
        height: 36px !important;
        align-items: center !important;
    }
    
    .flatpickr-weekday {
        color: #6b7280 !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        text-transform: uppercase;
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
        font-size: 13px !important;
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
        padding: 6px !important;
        background: transparent !important;
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
        background: transparent !important;
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
    #dateRangeCalendar_{{ $formId }} .flatpickr-calendar.inline {
        display: block !important;
        position: static !important;
        box-shadow: none !important;
        width: auto !important;
        max-width: none !important;
    }
    
    /* Ensure two months display side by side */
    #dateRangeCalendar_{{ $formId }} .flatpickr-months {
        display: flex !important;
        flex-wrap: nowrap !important;
    }
    
    /* Ensure calendar doesn't overflow */
    #dateRangeCalendar_{{ $formId }} {
        width: 100%;
        max-width: 100%;
    }
    
    /* Quick select buttons styling */
    .quick-date-btn-{{ $formId }} {
        transition: all 0.2s ease;
        font-size: 16px;
        padding: 8px 0 !important;
        border-radius: 0 !important;
        background-color: transparent !important;
        border: none !important;
        color: #1f2937 !important;
        font-weight: 600 !important;
    }
    
    .quick-date-btn-{{ $formId }}:hover {
        background-color: transparent !important;
        color: #ec3737 !important;
        border: none !important;
    }
    
    .quick-date-btn-{{ $formId }}:active,
    .quick-date-btn-{{ $formId }}.active {
        background-color: transparent !important;
        color: #ec3737 !important;
        border: none !important;
    }
    
    /* Filter hover styling */
    #{{ $formId }} .btn-outline-secondary:hover {
        background-color: #ec3737 !important;
        border-color: #ec3737 !important;
        color: #ffffff !important;
    }
    
    #{{ $formId }} .btn-outline-secondary:hover .text-secondary-light {
        color: #ffffff !important;
    }
    
    #{{ $formId }} select.form-select:hover {
        background-color: #ec3737 !important;
        border-color: #ec3737 !important;
        color: #ffffff !important;
    }
    
    /* Select dropdown options styling */
    #{{ $formId }} select.form-select option {
        background-color: #ffffff !important;
        color: #1f2937 !important;
        padding: 8px 12px;
    }
    
    #{{ $formId }} select.form-select option:hover {
        background-color: #ec3737 !important;
        color: #ffffff !important;
    }
    
    #{{ $formId }} select.form-select option:checked,
    #{{ $formId }} select.form-select option:focus {
        background-color: #ec3737 !important;
        color: #ffffff !important;
    }
    
    /* Status Filter Dropdown Styling */
    .hover-bg-light:hover {
        background-color: #f9fafb !important;
    }
    
    .status-filter-checkbox-{{ $formId }} {
        border-radius: 4px;
        border: 2px solid #d1d5db;
    }
    
    .status-filter-checkbox-{{ $formId }}:checked {
        background-color: #ec3737 !important;
        border-color: #ec3737 !important;
    }
</style>
@endpush

<!-- Date Range and Status Filter -->
<form method="GET" action="{{ $formAction }}" id="{{ $formId }}" class="mb-24 pb-24" style="border-bottom: 2px solid #e5e7eb;">
    <div class="d-flex flex-wrap align-items-center gap-3">
        <!-- Date Range Picker with Dropdown -->
        <div class="dropdown">
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" style="min-width: 300px; height: 42px; padding: 0 16px; gap: 10px; border-radius: 4px;">
                <i class="bi bi-calendar-range" style="font-size: 18px;"></i>
                <span id="dateRangeDisplay_{{ $formId }}" style="font-size: 18px; font-weight: 500;">
                    {{ $dateFrom && $dateTo ? \Carbon\Carbon::parse($dateFrom)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($dateTo)->format('M d, Y') : \Carbon\Carbon::now()->startOfMonth()->format('M d, Y') . ' - ' . \Carbon\Carbon::now()->format('M d, Y') }}
                </span>
            </button>
            <div class="dropdown-menu p-0" style="width: 800px; max-width: 95vw;" onclick="event.stopPropagation();">
                <div class="d-flex">
                    <!-- Quick Select Options -->
                    <div style="width: 160px; border-right: 1px solid #e5e7eb; padding: 16px 12px; flex-shrink: 0;">
                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn-{{ $formId }}" data-range="today">Today</button>
                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn-{{ $formId }}" data-range="yesterday">Yesterday</button>
                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn-{{ $formId }}" data-range="this_week">This week</button>
                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn-{{ $formId }}" data-range="month_to_date">Month to date</button>
                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn-{{ $formId }}" data-range="this_month">This month</button>
                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn-{{ $formId }}" data-range="last_month">Last month</button>
                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn-{{ $formId }}" data-range="this_quarter">This quarter</button>
                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn-{{ $formId }}" data-range="this_year">This year</button>
                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn-{{ $formId }}" data-range="year_to_date">Year to date</button>
                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn-{{ $formId }}" data-range="last_year">Last year</button>
                    </div>
                    <!-- Calendar -->
                    <div style="flex: 1; padding: 16px; min-width: 0; overflow-x: auto;">
                        <div id="dateRangeCalendar_{{ $formId }}"></div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="date_from" id="date_from_{{ $formId }}" value="{{ $dateFrom }}">
            <input type="hidden" name="date_to" id="date_to_{{ $formId }}" value="{{ $dateTo }}">
        </div>

        <!-- Status Filter Dropdown -->
        <div class="dropdown">
            <button type="button" class="btn btn-outline-secondary d-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="statusFilterDropdown_{{ $formId }}" style="min-width: 220px; height: 42px; padding: 0 40px 0 16px; border-radius: 4px; font-size: 18px; font-weight: 500; background-position: right 12px center;">
                <span id="statusFilterDisplay_{{ $formId }}">STATUS: {{ collect($statusOptions)->firstWhere('value', $statusFilter)['label'] ?? 'All' }} {{ $moduleLabel }}</span>
            </button>
            <div class="dropdown-menu p-0" style="min-width: 300px; border-radius: 6px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);" onclick="event.stopPropagation();">
                <!-- Header -->
                <div class="d-flex align-items-center justify-content-between px-20 py-16" style="border-bottom: 1px solid #e5e7eb;">
                    <div>
                        <span class="fw-bold" style="font-size: 18px; color: #1f2937;">All</span>
                        <span class="fw-bold" style="font-size: 18px; color: #ec3737;" id="selectedCount_{{ $formId }}">({{ $totalCount }})</span>
                    </div>
                    <button type="button" class="btn btn-link p-0 text-decoration-none" style="font-size: 16px; color: #ec3737;" onclick="clearStatusFilters_{{ $formId }}()">Clear</button>
                </div>
                
                <!-- Filter Options -->
                <div class="px-12 py-12" style="max-height: 300px; overflow-y: auto;">
                    @foreach($statusOptions as $option)
                    <label class="d-flex align-items-center px-12 py-10 rounded cursor-pointer hover-bg-light" style="cursor: pointer; transition: all 0.2s;">
                        <input type="checkbox" class="status-filter-checkbox-{{ $formId }}" value="{{ $option['value'] }}" {{ $statusFilter === $option['value'] ? 'checked' : '' }} style="width: 20px; height: 20px; margin-right: 12px; cursor: pointer; accent-color: #ec3737;">
                        <span style="font-size: 18px; color: #1f2937; font-weight: 500;">{{ $option['label'] }} {{ $moduleLabel }}</span>
                    </label>
                    @endforeach
                </div>
                
                <!-- Footer Actions -->
                <div class="d-flex align-items-center justify-content-end gap-2 px-16 py-16" style="border-top: 1px solid #e5e7eb;">
                    <button type="button" class="btn btn-outline-secondary" style="padding: 10px 24px; font-size: 18px; border-radius: 4px; font-weight: 500;" onclick="$('#statusFilterDropdown_{{ $formId }}').dropdown('hide')">Cancel</button>
                    <button type="button" class="btn text-white" style="padding: 10px 28px; font-size: 18px; border-radius: 4px; font-weight: 500; background-color: #ec3737;" onclick="applyStatusFilter_{{ $formId }}()" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">Apply</button>
                </div>
            </div>
            <input type="hidden" name="filter" id="filterValue_{{ $formId }}" value="{{ $statusFilter }}">
        </div>

        @if($showRefreshButton)
        <!-- Refresh Button -->
        <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" onclick="refreshData_{{ $formId }}()" style="height: 42px; padding: 0 20px; gap: 10px; border-radius: 4px;">
            <i class="bi bi-arrow-clockwise" style="font-size: 18px;"></i>
            <span style="font-size: 18px; font-weight: 500;">Refresh</span>
        </button>
        @endif

        @if($showCreateButton)
        <!-- Create Button -->
        <button type="button" class="btn text-white d-flex align-items-center justify-content-center ms-auto" data-bs-toggle="modal" data-bs-target="#{{ $createButtonModal }}" style="background-color: #ec3737; height: 42px; padding: 0 20px; gap: 10px; border-radius: 4px;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
            <i class="bi {{ $createButtonIcon }}" style="font-size: 18px;"></i>
            <span style="font-size: 18px; font-weight: 500;">{{ $createButtonText }}</span>
        </button>
        @endif

        {{ $slot }}
    </div>
</form>

@push('scripts')
<script>
(function() {
    const formId = '{{ $formId }}';
    
    // Initialize Date Range Picker
    $(document).ready(function() {
        let dateRangePicker = null;
        
        // Get the dropdown button
        const dropdownButton = $(`#${formId}`).find('.dropdown-toggle[data-bs-toggle="dropdown"]').first();
        
        // Initialize Flatpickr when dropdown is clicked/opened
        dropdownButton.on('click', function() {
            setTimeout(function() {
                if (!dateRangePicker) {
                    const calendarElement = document.getElementById(`dateRangeCalendar_${formId}`);
                    if (calendarElement && typeof flatpickr !== 'undefined') {
                        dateRangePicker = flatpickr(calendarElement, {
                            mode: "range",
                            inline: true,
                            showMonths: 2,
                            dateFormat: "Y-m-d",
                            defaultDate: ["{{ $dateFrom }}", "{{ $dateTo }}"],
                            onChange: function(selectedDates, dateStr, instance) {
                                if (selectedDates.length === 2) {
                                    updateDateRange(selectedDates[0], selectedDates[1]);
                                    setTimeout(function() {
                                        dropdownButton.dropdown('hide');
                                    }, 300);
                                }
                            }
                        });
                    }
                }
            }, 100);
        });

        // Quick date range buttons
        document.querySelectorAll(`.quick-date-btn-${formId}`).forEach(btn => {
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
            
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            const fromStr = fromDate.toLocaleDateString('en-US', options);
            const toStr = toDate.toLocaleDateString('en-US', options);
            
            document.getElementById(`dateRangeDisplay_${formId}`).textContent = fromStr + ' - ' + toStr;
            document.getElementById(`date_from_${formId}`).value = formatDate(fromDate);
            document.getElementById(`date_to_${formId}`).value = formatDate(toDate);
            
            document.getElementById(formId).submit();
        }

        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
    });

    // Status Filter Functions
    window[`updateSelectedCount_${formId}`] = function() {
        const checkboxes = document.querySelectorAll(`.status-filter-checkbox-${formId}:checked`);
        const count = checkboxes.length;
        document.getElementById(`selectedCount_${formId}`).textContent = '(' + count + ')';
    };

    window[`clearStatusFilters_${formId}`] = function() {
        const checkboxes = document.querySelectorAll(`.status-filter-checkbox-${formId}`);
        checkboxes.forEach(cb => cb.checked = false);
        const allCheckbox = document.querySelector(`.status-filter-checkbox-${formId}[value="all"]`);
        if (allCheckbox) allCheckbox.checked = true;
        window[`updateSelectedCount_${formId}`]();
    };

    window[`applyStatusFilter_${formId}`] = function() {
        const checkboxes = document.querySelectorAll(`.status-filter-checkbox-${formId}:checked`);
        const allCheckbox = document.querySelector(`.status-filter-checkbox-${formId}[value="all"]`);
        
        let filterValue = 'all';
        let displayText = 'STATUS: All {{ $moduleLabel }}';
        
        if (checkboxes.length === 1 && !allCheckbox.checked) {
            const selected = checkboxes[0];
            filterValue = selected.value;
            const label = selected.closest('label').querySelector('span').textContent;
            displayText = 'STATUS: ' + label;
        } else if (checkboxes.length > 1 && !allCheckbox.checked) {
            filterValue = Array.from(checkboxes).map(cb => cb.value).join(',');
            displayText = 'STATUS: Multiple (' + checkboxes.length + ')';
        }
        
        document.getElementById(`filterValue_${formId}`).value = filterValue;
        document.getElementById(`statusFilterDisplay_${formId}`).textContent = displayText;
        
        $(`#statusFilterDropdown_${formId}`).dropdown('hide');
        document.getElementById(formId).submit();
    };

    @if($showRefreshButton && $refreshUrl)
    window[`refreshData_${formId}`] = function() {
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Refreshing...';
        
        fetch('{{ $refreshUrl }}', {
            method: '{{ $refreshMethod }}',
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
                    text: data.message || 'Data has been refreshed.',
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
                text: 'Failed to refresh data. Please try again.'
            });
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    };
    @elseif($showRefreshButton)
    window[`refreshData_${formId}`] = function() {
        window.location.reload();
    };
    @endif

    // Handle "All" checkbox behavior
    $(document).ready(function() {
        const allCheckbox = document.querySelector(`.status-filter-checkbox-${formId}[value="all"]`);
        const otherCheckboxes = document.querySelectorAll(`.status-filter-checkbox-${formId}:not([value="all"])`);
        
        if (allCheckbox) {
            allCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    otherCheckboxes.forEach(cb => cb.checked = false);
                }
                window[`updateSelectedCount_${formId}`]();
            });
        }
        
        otherCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (this.checked && allCheckbox) {
                    allCheckbox.checked = false;
                }
                const anyChecked = Array.from(otherCheckboxes).some(checkbox => checkbox.checked);
                if (!anyChecked && allCheckbox) {
                    allCheckbox.checked = true;
                }
                window[`updateSelectedCount_${formId}`]();
            });
        });
        
        window[`updateSelectedCount_${formId}`]();
    });
})();
</script>
@endpush

