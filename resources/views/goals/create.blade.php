<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Create New Goal</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('goals.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Goals
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Create Goal</li>
            </ul>
        </div>

        <!-- Display Validation Errors -->
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-24" role="alert">
            <h6 class="fw-bold mb-12">Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-24" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('goals.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <!-- Basic Information Card -->
                    <div class="card mb-24 border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                    <iconify-icon icon="mdi:information-outline" class="text-white" style="font-size: 18px;"></iconify-icon>
                                </div>
                                <h6 class="card-title mb-0 fw-bold">Basic Information</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Goal Name -->
                            <div class="mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Goal Name <span class="text-danger-600">*</span></label>
                                <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g., Achieve $50,000 in Sales This Month" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-20">
                                <label for="description" class="form-label fw-semibold text-primary-light text-sm mb-8">Description (Optional)</label>
                                <textarea class="form-control radius-8 @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Describe your goal and why it's important...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Goal Type -->
                            <div class="mb-20">
                                <label for="goal_type" class="form-label fw-semibold text-primary-light text-sm mb-8">Goal Type <span class="text-danger-600">*</span></label>
                                <select class="form-select radius-8 @error('goal_type') is-invalid @enderror" id="goal_type" name="goal_type" required onchange="handleGoalTypeChange(this.value)">
                                    <option value="">Select Goal Type</option>
                                    <option value="sales_revenue" {{ old('goal_type') === 'sales_revenue' ? 'selected' : '' }}>Sales Revenue</option>
                                    <option value="sales_volume" {{ old('goal_type') === 'sales_volume' ? 'selected' : '' }}>Sales Volume (Number of Transactions)</option>
                                    <option value="product_sales" {{ old('goal_type') === 'product_sales' ? 'selected' : '' }}>Product Sales</option>
                                    <option value="customer_acquisition" {{ old('goal_type') === 'customer_acquisition' ? 'selected' : '' }}>Customer Acquisition</option>
                                    <option value="expense_reduction" {{ old('goal_type') === 'expense_reduction' ? 'selected' : '' }}>Expense Reduction</option>
                                    <option value="profit_margin" {{ old('goal_type') === 'profit_margin' ? 'selected' : '' }}>Profit Margin (%)</option>
                                    <option value="custom" {{ old('goal_type') === 'custom' ? 'selected' : '' }}>Custom Goal</option>
                                </select>
                                @error('goal_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-8 text-sm text-secondary-light">
                                    <iconify-icon icon="mdi:information" class="icon-sm"></iconify-icon>
                                    <span id="goal-type-hint">Select a goal type to see description</span>
                                </div>
                            </div>

                            <!-- Target Amount -->
                            <div class="mb-20">
                                <label for="target_amount" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Target <span id="target-label-suffix"></span> <span class="text-danger-600">*</span>
                                </label>
                                <input type="number" step="0.01" min="0" class="form-control radius-8 @error('target_amount') is-invalid @enderror" id="target_amount" name="target_amount" value="{{ old('target_amount') }}" placeholder="0.00" required>
                                @error('target_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Time Period -->
                            <div class="row">
                                <div class="col-md-6 mb-20">
                                    <label for="start_date" class="form-label fw-semibold text-primary-light text-sm mb-8">Start Date <span class="text-danger-600">*</span></label>
                                    <input type="date" class="form-control radius-8 @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label for="end_date" class="form-label fw-semibold text-primary-light text-sm mb-8">End Date <span class="text-danger-600">*</span></label>
                                    <input type="date" class="form-control radius-8 @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Conditional Filters -->
                            <div id="product-filter" class="mb-20" style="display: none;">
                                <label for="product_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Specific Product (Optional)</label>
                                <select class="form-select radius-8" id="product_id" name="product_id">
                                    <option value="">All Products</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="category-filter" class="mb-20" style="display: none;">
                                <label for="product_category_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Product Category (Optional)</label>
                                <select class="form-select radius-8" id="product_category_id" name="product_category_id">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="channel-filter" class="mb-20" style="display: none;">
                                <label for="sales_channel_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Sales Channel (Optional)</label>
                                <select class="form-select radius-8" id="sales_channel_id" name="sales_channel_id">
                                    <option value="">All Channels</option>
                                    @foreach($channels as $channel)
                                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Priority and Actions -->
                    <div class="card mb-24 border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="card-title mb-0 fw-bold">Settings</h6>
                        </div>
                        <div class="card-body">
                            <!-- Priority -->
                            <div class="mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Priority <span class="text-danger-600">*</span></label>
                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="priority" id="priority-low" value="low" {{ old('priority', 'medium') === 'low' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="priority-low">
                                            <span class="badge bg-neutral-200 text-neutral-600">Low Priority</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="priority" id="priority-medium" value="medium" {{ old('priority', 'medium') === 'medium' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="priority-medium">
                                            <span class="badge bg-warning-100 text-warning-600">Medium Priority</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="priority" id="priority-high" value="high" {{ old('priority') === 'high' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="priority-high">
                                            <span class="badge bg-danger-100 text-danger-600">
                                                <iconify-icon icon="mdi:fire" class="icon-sm"></iconify-icon> High Priority
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 mt-24">
                                <button type="submit" class="btn text-white radius-8 px-20 py-11 flex-grow-1" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                                    <iconify-icon icon="mdi:check" class="icon"></iconify-icon>
                                    Create Goal
                                </button>
                                <a href="{{ route('goals.index') }}" class="btn btn-outline-secondary radius-8 px-20 py-11">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Goal Type Info -->
                    <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-12">
                                <iconify-icon icon="mdi:lightbulb-on" style="color: #ec3737; font-size: 24px;"></iconify-icon>
                                <h6 class="fw-bold mb-0">Quick Tips</h6>
                            </div>
                            <ul class="text-sm text-secondary-light mb-0 ps-3">
                                <li class="mb-8">Choose a goal type that aligns with your business priorities</li>
                                <li class="mb-8">Set realistic targets based on historical performance</li>
                                <li class="mb-8">Progress is automatically tracked from your sales data</li>
                                <li>You can edit or pause goals anytime</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        const goalTypeHints = {
            'sales_revenue': 'Track total revenue from sales within the period',
            'sales_volume': 'Track the number of sales transactions',
            'product_sales': 'Track revenue from specific products or categories',
            'customer_acquisition': 'Track new customers gained in the period',
            'expense_reduction': 'Track savings compared to previous period',
            'profit_margin': 'Track profit margin percentage',
            'custom': 'Set your own custom goal with manual tracking'
        };

        const targetLabels = {
            'sales_revenue': 'Amount',
            'sales_volume': 'Number of Sales',
            'product_sales': 'Amount',
            'customer_acquisition': 'Number of Customers',
            'expense_reduction': 'Amount to Save',
            'profit_margin': 'Percentage (%)',
            'custom': 'Value'
        };

        function handleGoalTypeChange(type) {
            const hint = document.getElementById('goal-type-hint');
            const targetSuffix = document.getElementById('target-label-suffix');
            const productFilter = document.getElementById('product-filter');
            const categoryFilter = document.getElementById('category-filter');
            const channelFilter = document.getElementById('channel-filter');

            // Update hint
            hint.textContent = goalTypeHints[type] || 'Select a goal type to see description';
            
            // Update target label
            targetSuffix.textContent = targetLabels[type] ? `(${targetLabels[type]})` : '';

            // Show/hide filters
            productFilter.style.display = 'none';
            categoryFilter.style.display = 'none';
            channelFilter.style.display = 'none';

            if (type === 'product_sales') {
                productFilter.style.display = 'block';
                categoryFilter.style.display = 'block';
            }

            if (type === 'sales_revenue' || type === 'sales_volume') {
                channelFilter.style.display = 'block';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const goalType = document.getElementById('goal_type').value;
            if (goalType) {
                handleGoalTypeChange(goalType);
            }
        });
    </script>
    @endpush

</x-layout.master>

