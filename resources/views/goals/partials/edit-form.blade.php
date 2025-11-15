<form action="{{ route('goals.update', $goal) }}" method="POST" id="editGoalForm">
    @csrf
    @method('PUT')
    
    <!-- Basic Information Section -->
    <div class="mb-24">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <iconify-icon icon="mdi:information-outline" class="text-white" style="font-size: 16px;"></iconify-icon>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Basic Information</h6>
        </div>
        
        <div class="row">
            <!-- Goal Name -->
            <div class="col-12 mb-20">
                <label for="edit_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Goal Name <span class="text-danger-600">*</span>
                </label>
                <input type="text" class="form-control radius-8" id="edit_name" name="name" value="{{ $goal->name }}" placeholder="e.g., Achieve $50,000 in Sales This Month" required>
            </div>

            <!-- Description -->
            <div class="col-12 mb-20">
                <label for="edit_description" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Description (Optional)
                </label>
                <textarea class="form-control radius-8" id="edit_description" name="description" rows="2" placeholder="Describe your goal and why it's important...">{{ $goal->description }}</textarea>
            </div>
        </div>
    </div>
    
    <!-- Goal Configuration Section -->
    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <iconify-icon icon="mdi:cog-outline" class="text-white" style="font-size: 16px;"></iconify-icon>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Goal Configuration</h6>
        </div>
        
        <div class="row">

        <!-- Goal Type -->
        <div class="col-md-6 mb-20">
            <label for="edit_goal_type" class="form-label fw-semibold text-primary-light text-sm mb-8">
                Goal Type <span class="text-danger-600">*</span>
            </label>
            <select class="form-select radius-8" id="edit_goal_type" name="goal_type" required onchange="handleEditGoalTypeChange(this.value)">
                <option value="">Select Goal Type</option>
                <option value="sales_revenue" {{ $goal->goal_type === 'sales_revenue' ? 'selected' : '' }}>Sales Revenue</option>
                <option value="sales_volume" {{ $goal->goal_type === 'sales_volume' ? 'selected' : '' }}>Sales Volume (Transactions)</option>
                <option value="product_sales" {{ $goal->goal_type === 'product_sales' ? 'selected' : '' }}>Product Sales</option>
                <option value="customer_acquisition" {{ $goal->goal_type === 'customer_acquisition' ? 'selected' : '' }}>Customer Acquisition</option>
                <option value="expense_reduction" {{ $goal->goal_type === 'expense_reduction' ? 'selected' : '' }}>Expense Reduction</option>
                <option value="profit_margin" {{ $goal->goal_type === 'profit_margin' ? 'selected' : '' }}>Profit Margin (%)</option>
                <option value="custom" {{ $goal->goal_type === 'custom' ? 'selected' : '' }}>Custom Goal</option>
            </select>
        </div>

        <!-- Target Amount -->
        <div class="col-md-6 mb-20">
            <label for="edit_target_amount" class="form-label fw-semibold text-primary-light text-sm mb-8">
                Target <span id="edit_target_label"></span> <span class="text-danger-600">*</span>
            </label>
            <input type="number" step="0.01" min="0" class="form-control radius-8" id="edit_target_amount" name="target_amount" value="{{ $goal->target_amount }}" placeholder="0.00" required>
        </div>

        <!-- Date Range -->
        <div class="col-12 mb-20">
            <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                Goal Period <span class="text-danger-600">*</span>
            </label>
            <div class="input-group date-range-input-group">
                <span class="input-group-text bg-white border-end-0" style="border-radius: 8px 0 0 8px; border: 1px solid #e5e7eb;">
                    <iconify-icon icon="mdi:calendar-range" style="font-size: 18px; color: #ec3737;"></iconify-icon>
                </span>
                <input type="text" class="form-control border-start-0" id="edit_date_range" placeholder="Select start and end date" readonly style="background-color: #ffffff; cursor: pointer; border-radius: 0 8px 8px 0; font-weight: 500; color: #1f2937; border: 1px solid #e5e7eb; padding: 10px 12px;">
            </div>
            <style>
                /* Flatpickr Calendar Styling for Edit Form */
                .flatpickr-calendar {
                    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
                    border: none !important;
                    border-radius: 12px !important;
                    padding: 16px !important;
                    width: auto !important;
                    min-width: 320px !important;
                }
                
                .flatpickr-months {
                    background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%) !important;
                    border-radius: 12px 12px 0 0 !important;
                    padding: 16px !important;
                    margin: -16px -16px 16px -16px !important;
                }
                
                .flatpickr-month {
                    color: #ffffff !important;
                }
                
                .flatpickr-current-month {
                    color: #ffffff !important;
                }
                
                .flatpickr-current-month .flatpickr-monthDropdown-months {
                    background: transparent !important;
                    color: #ffffff !important;
                    font-weight: 600 !important;
                }
                
                .flatpickr-current-month .numInputWrapper {
                    background: transparent !important;
                }
                
                .flatpickr-current-month .numInput {
                    color: #ffffff !important;
                    font-weight: 600 !important;
                }
                
                .flatpickr-prev-month svg,
                .flatpickr-next-month svg {
                    fill: #ffffff !important;
                }
                
                .flatpickr-prev-month:hover svg,
                .flatpickr-next-month:hover svg {
                    fill: #ffffff !important;
                }
                
                .flatpickr-prev-month:hover,
                .flatpickr-next-month:hover {
                    background: rgba(255, 255, 255, 0.2) !important;
                    border-radius: 50%;
                }
                
                .flatpickr-weekdays {
                    background: #f9fafb !important;
                    padding: 12px 0 !important;
                    margin: 0 -16px !important;
                    width: calc(100% + 32px) !important;
                }
                
                .flatpickr-weekday {
                    color: #6b7280 !important;
                    font-weight: 600 !important;
                    font-size: 12px !important;
                }
                
                .flatpickr-days {
                    margin: 0 !important;
                    padding: 0 !important;
                    width: 100% !important;
                }
                
                .flatpickr-innerContainer {
                    width: 100% !important;
                }
                
                .flatpickr-rContainer {
                    width: 100% !important;
                }
                
                .flatpickr-day {
                    color: #1f2937 !important;
                    border-radius: 8px !important;
                    font-weight: 500 !important;
                    margin: 3px !important;
                }
                
                .flatpickr-day:hover {
                    background: #fee2e2 !important;
                    border-color: #fee2e2 !important;
                }
                
                .flatpickr-day.today {
                    border: 2px solid #ec3737 !important;
                    color: #ec3737 !important;
                    font-weight: 700 !important;
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
                    border-color: #fee2e2 !important;
                    box-shadow: none !important;
                    color: #dc2626 !important;
                }
                
                .flatpickr-day.prevMonthDay,
                .flatpickr-day.nextMonthDay {
                    color: #d1d5db !important;
                }
                
                .date-range-input-group:focus-within .input-group-text {
                    border-color: #ec3737 !important;
                }
                
                .date-range-input-group:focus-within input {
                    border-color: #ec3737 !important;
                    box-shadow: 0 0 0 3px rgba(236, 55, 55, 0.1) !important;
                }
            </style>
            <input type="hidden" id="edit_start_date" name="start_date" value="{{ $goal->start_date->format('Y-m-d') }}" required>
            <input type="hidden" id="edit_end_date" name="end_date" value="{{ $goal->end_date->format('Y-m-d') }}" required>
        </div>

        <!-- Conditional Filters -->
        <div class="col-12">
            <!-- Product Filter -->
            <div id="edit_product_filter" style="display: none;" class="mb-12">
                <label for="edit_product_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Product (Optional)
                </label>
                <select class="form-select radius-8" id="edit_product_id" name="product_id">
                    <option value="">All Products</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $goal->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div id="edit_category_filter" style="display: none;" class="mb-12">
                <label for="edit_product_category_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Category (Optional)
                </label>
                <select class="form-select radius-8" id="edit_product_category_id" name="product_category_id">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $goal->product_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Channel Filter -->
            <div id="edit_channel_filter" style="display: none;">
                <label for="edit_sales_channel_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Sales Channel (Optional)
                </label>
                <select class="form-select radius-8" id="edit_sales_channel_id" name="sales_channel_id">
                    <option value="">All Channels</option>
                    @foreach($channels as $channel)
                    <option value="{{ $channel->id }}" {{ $goal->sales_channel_id == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        </div>
    </div>
    
    <!-- Settings Section -->
    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <iconify-icon icon="mdi:tune-variant" class="text-white" style="font-size: 16px;"></iconify-icon>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Settings</h6>
        </div>
        
        <div class="row">
            <!-- Priority -->
            <div class="col-md-6 mb-20">
                <label class="form-label fw-semibold text-primary-light text-sm mb-12">
                    Priority Level <span class="text-danger-600">*</span>
                </label>
                <div class="d-flex flex-column gap-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="priority" id="edit_priority_low" value="low" {{ $goal->priority === 'low' ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_priority_low">
                            <span class="badge bg-neutral-200 text-neutral-600 px-12 py-6">Low Priority</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="priority" id="edit_priority_medium" value="medium" {{ $goal->priority === 'medium' ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_priority_medium">
                            <span class="badge bg-warning-100 text-warning-600 px-12 py-6">Medium Priority</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="priority" id="edit_priority_high" value="high" {{ $goal->priority === 'high' ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_priority_high">
                            <span class="badge bg-danger-100 text-danger-600 px-12 py-6">
                                <iconify-icon icon="mdi:fire" class="icon-sm"></iconify-icon> High Priority
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Status -->
            <div class="col-md-6 mb-20">
                <label for="edit_status" class="form-label fw-semibold text-primary-light text-sm mb-12">
                    Goal Status <span class="text-danger-600">*</span>
                </label>
                <select class="form-select radius-8" id="edit_status" name="status" required>
                    <option value="active" {{ $goal->status === 'active' ? 'selected' : '' }}>🎯 Active</option>
                    <option value="paused" {{ $goal->status === 'paused' ? 'selected' : '' }}>⏸️ Paused</option>
                    <option value="completed" {{ $goal->status === 'completed' ? 'selected' : '' }}>✅ Completed</option>
                    <option value="failed" {{ $goal->status === 'failed' ? 'selected' : '' }}>❌ Failed</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="d-flex justify-content-end gap-3 mt-24 pt-24" style="border-top: 1px solid #e5e7eb;">
        <button type="button" class="btn btn-outline-secondary radius-8 d-flex align-items-center gap-2" style="padding: 11px 24px; font-size: 14px; font-weight: 500; transition: all 0.2s ease;" data-bs-dismiss="modal">
            <iconify-icon icon="mdi:close" style="font-size: 18px;"></iconify-icon>
            <span>Cancel</span>
        </button>
        <button type="submit" class="btn text-white radius-8 d-flex align-items-center gap-2" style="background-color: #ec3737; padding: 11px 24px; font-size: 14px; font-weight: 500; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
            <iconify-icon icon="mdi:content-save" style="font-size: 18px;"></iconify-icon>
            <span>Update Goal</span>
        </button>
    </div>
</form>

<script>
function handleEditGoalTypeChange(type) {
    // Hide all conditional filters
    document.getElementById('edit_product_filter').style.display = 'none';
    document.getElementById('edit_category_filter').style.display = 'none';
    document.getElementById('edit_channel_filter').style.display = 'none';
    
    // Update target label
    const label = document.getElementById('edit_target_label');
    
    switch(type) {
        case 'sales_revenue':
            label.textContent = 'Amount';
            document.getElementById('edit_channel_filter').style.display = 'block';
            break;
        case 'sales_volume':
            label.textContent = '(Number of Transactions)';
            document.getElementById('edit_channel_filter').style.display = 'block';
            break;
        case 'product_sales':
            label.textContent = 'Amount';
            document.getElementById('edit_product_filter').style.display = 'block';
            document.getElementById('edit_category_filter').style.display = 'block';
            break;
        case 'customer_acquisition':
            label.textContent = '(Number of Customers)';
            break;
        case 'expense_reduction':
            label.textContent = 'Amount';
            break;
        case 'profit_margin':
            label.textContent = '(Percentage %)';
            break;
        case 'custom':
            label.textContent = '';
            break;
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    handleEditGoalTypeChange('{{ $goal->goal_type }}');
});
</script>

