@props([
    'formId' => 'filterForm',
    'statusFilter' => request('filter', 'all'),
    'statusOptions' => [
        ['value' => 'all', 'label' => 'All'],
        ['value' => 'active', 'label' => 'Active'],
        ['value' => 'completed', 'label' => 'Completed']
    ],
    'totalCount' => 0,
    'moduleLabel' => 'Items',
    'autoSubmit' => true,
    'parameterName' => 'filter' // The name attribute for the hidden input
])

@push('styles')
<style>
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

<!-- Status Filter Dropdown -->
<div class="dropdown" style="flex-shrink: 0;">
    <button type="button" class="btn btn-outline-secondary d-flex align-items-center dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="statusFilterDropdown_{{ $formId }}" style="width: 220px; height: 42px; padding: 0 40px 0 16px; border-radius: 8px; font-size: 16px; font-weight: 500; background-position: right 12px center; white-space: nowrap;">
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
        <div class="d-flex align-items-center justify-content-end gap-2 px-16 py-12" style="border-top: 1px solid #e5e7eb;">
            <button type="button" class="btn btn-outline-secondary btn-sm" style="padding: 6px 16px; font-size: 14px; border-radius: 6px; font-weight: 500;" onclick="$('#statusFilterDropdown_{{ $formId }}').dropdown('hide')">Cancel</button>
            <button type="button" class="btn btn-sm text-white" style="padding: 6px 20px; font-size: 14px; border-radius: 6px; font-weight: 500; background-color: #ec3737;" onclick="applyStatusFilter_{{ $formId }}()" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">Apply</button>
        </div>
    </div>
    <input type="hidden" name="{{ $parameterName }}" id="filterValue_{{ $formId }}" value="{{ $statusFilter }}">
</div>

@push('scripts')
<script>
(function() {
    const formId = '{{ $formId }}';
    const autoSubmit = {{ $autoSubmit ? 'true' : 'false' }};
    
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
        
        // Auto-submit form if enabled
        if (autoSubmit) {
            const form = document.getElementById(`filterValue_${formId}`).closest('form');
            if (form) {
                form.submit();
            }
        }
    };

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

