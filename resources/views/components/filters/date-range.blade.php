@props([
    'formAction' => '',
    'formId' => 'filterForm',
    'dateFrom' => request('date_from', now()->startOfMonth()->format('Y-m-d')),
    'dateTo' => request('date_to', now()->format('Y-m-d')),
    'showSubmitButton' => false,
    'submitButtonText' => 'Filter',
    'autoSubmit' => true
])

@php
    $fromDate = $dateFrom ? \Carbon\Carbon::parse($dateFrom) : now()->startOfMonth();
    $toDate = $dateTo ? \Carbon\Carbon::parse($dateTo) : now();
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">
<style>
    /* Date Range Input Styling */
    .date-range-input-{{ $formId }} {
        width: 300px;
        height: 42px;
        flex-shrink: 0;
    }
    
    .date-range-input-{{ $formId }} .input-group-text {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 12px;
    }
    
    .date-range-input-{{ $formId }} .input-group-text i {
        font-size: 18px;
        color: #6b7280;
    }
    
    .date-range-input-{{ $formId }}:focus-within .input-group-text {
        border-color: #ec3737 !important;
    }
    
    .date-range-input-{{ $formId }}:focus-within .input-group-text i {
        color: #ec3737;
    }
    
    .date-range-input-{{ $formId }}:focus-within input {
        border-color: #ec3737 !important;
        box-shadow: 0 0 0 3px rgba(236, 55, 55, 0.1) !important;
    }

    /* Flatpickr Calendar Styling - Clean White Design */
    .flatpickr-calendar {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 8px !important;
        padding: 16px !important;
        width: auto !important;
        min-width: 320px !important;
    }
    
    .flatpickr-months {
        background: #ffffff !important;
        padding: 12px 0 !important;
        margin-bottom: 12px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 12px !important;
    }
    
    .flatpickr-month {
        color: #1f2937 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        position: static !important;
        height: auto !important;
    }
    
    .flatpickr-current-month {
        color: #1f2937 !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        position: static !important;
        height: auto !important;
        padding: 0 !important;
    }
    
    .flatpickr-prev-month,
    .flatpickr-next-month {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 4px !important;
        cursor: pointer !important;
        position: static !important;
        width: auto !important;
        height: auto !important;
    }
    
    .flatpickr-current-month .flatpickr-monthDropdown-months {
        background: transparent !important;
        color: #1f2937 !important;
        font-weight: 600 !important;
        border: none !important;
    }
    
    .flatpickr-current-month .numInputWrapper {
        background: transparent !important;
    }
    
    .flatpickr-current-month .numInput {
        color: #1f2937 !important;
        font-weight: 600 !important;
    }
    
    .flatpickr-prev-month svg,
    .flatpickr-next-month svg {
        fill: #6b7280 !important;
    }
    
    .flatpickr-prev-month:hover svg,
    .flatpickr-next-month:hover svg {
        fill: #ec3737 !important;
    }
    
    .flatpickr-weekdays {
        background: transparent !important;
        padding: 8px 0 !important;
        border-bottom: 1px solid #e5e7eb !important;
        margin-bottom: 8px !important;
    }
    
    .flatpickr-weekday {
        color: #6b7280 !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        text-align: center !important;
    }
    
    .flatpickr-days {
        padding: 4px !important;
    }
    
    .flatpickr-day {
        color: #1f2937 !important;
        border-radius: 8px !important;
        font-weight: 500 !important;
    }
    
    .flatpickr-day:hover {
        background: #f3f4f6 !important;
        border-color: transparent !important;
    }
    
    .flatpickr-day.today {
        background: #ec3737 !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
    }
    
    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange {
        background: #ec3737 !important;
        border-color: #ec3737 !important;
        color: #ffffff !important;
        font-weight: 600 !important;
    }
    
    .flatpickr-day.inRange {
        background: #fee2e2 !important;
        border-color: transparent !important;
        box-shadow: none !important;
        color: #991b1b !important;
    }
    
    .flatpickr-day.prevMonthDay,
    .flatpickr-day.nextMonthDay {
        color: #d1d5db !important;
    }
    
    .flatpickr-day.flatpickr-disabled {
        color: #e5e7eb !important;
    }
</style>
@endpush

<!-- Date Range Picker Input -->
<div class="input-group date-range-input-{{ $formId }}">
    <span class="input-group-text bg-white border-end-0" style="border-radius: 8px 0 0 8px; border: 1px solid #e5e7eb;">
        <i class="bi bi-calendar-range"></i>
    </span>
    <input type="text" 
           class="form-control border-start-0" 
           id="dateRange_{{ $formId }}" 
           placeholder="Select start and end date" 
           readonly 
           style="background-color: #ffffff; cursor: pointer; border-radius: 0 8px 8px 0; font-weight: 500; color: #1f2937; border: 1px solid #e5e7eb; padding: 10px 12px; font-size: 16px;">
    <input type="hidden" name="date_from" id="date_from_{{ $formId }}" value="{{ $dateFrom }}">
    <input type="hidden" name="date_to" id="date_to_{{ $formId }}" value="{{ $dateTo }}">
</div>

@if($showSubmitButton)
<button type="submit" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="height: 42px; padding: 0 20px; gap: 10px; border-radius: 4px;">
    <i class="bi bi-arrow-clockwise" style="font-size: 18px;"></i>
    <span style="font-size: 18px; font-weight: 500;">{{ $submitButtonText }}</span>
</button>
@endif

@push('scripts')
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script>
(function() {
    const formId = '{{ $formId }}';
    const autoSubmit = {{ $autoSubmit ? 'true' : 'false' }};
    
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById(`dateRange_${formId}`);
        
        if (input && typeof flatpickr !== 'undefined') {
            const picker = flatpickr(input, {
                mode: "range",
                dateFormat: "M d, Y",
                defaultDate: ["{{ $dateFrom }}", "{{ $dateTo }}"],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        const fromDate = selectedDates[0];
                        const toDate = selectedDates[1];
                        
                        // Update hidden inputs
                        document.getElementById(`date_from_${formId}`).value = formatDate(fromDate);
                        document.getElementById(`date_to_${formId}`).value = formatDate(toDate);
                        
                        // Auto-submit if enabled
                        if (autoSubmit) {
                            const form = input.closest('form');
                            if (form) {
                                form.submit();
                            }
                        }
                    }
                }
            });
            
            // Set initial display value
            if ("{{ $dateFrom }}" && "{{ $dateTo }}") {
                const fromDate = new Date("{{ $dateFrom }}");
                const toDate = new Date("{{ $dateTo }}");
                const options = { year: 'numeric', month: 'short', day: 'numeric' };
                input.value = fromDate.toLocaleDateString('en-US', options) + ' - ' + toDate.toLocaleDateString('en-US', options);
            }
        }
        
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
    });
})();
</script>
@endpush
