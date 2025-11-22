# Separated Filter Components

## Overview

The filter functionality has been separated into two independent, reusable components:

1. **Date Range Filter** (`date-range.blade.php`) - For date-based filtering
2. **Status Filter** (`status-filter.blade.php`) - For status/category filtering

This separation provides maximum flexibility - use them individually or combine them as needed.

## Components

### 1. Date Range Filter Component

**Location**: `resources/views/components/filters/date-range.blade.php`

#### Features
- 2-month inline calendar view
- 10 quick date range presets (Today, Yesterday, This Week, etc.)
- Auto-submit on date selection (configurable)
- Optional manual submit button
- Fully isolated CSS and JavaScript

#### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `formId` | string | 'filterForm' | Unique ID for component isolation |
| `dateFrom` | string | Current month start | Start date (Y-m-d format) |
| `dateTo` | string | Today | End date (Y-m-d format) |
| `showSubmitButton` | boolean | false | Show manual submit button |
| `submitButtonText` | string | 'Filter' | Text for submit button |
| `autoSubmit` | boolean | true | Auto-submit form on date selection |

#### Basic Usage

```blade
<form method="GET" action="{{ route('module.index') }}" id="filterForm">
    <div class="d-flex gap-3">
        <x-filters.date-range 
            form-id="filterForm"
            :date-from="request('date_from')"
            :date-to="request('date_to')"
        />
    </div>
</form>
```

#### With Submit Button

```blade
<form method="GET" action="{{ route('module.index') }}" id="filterForm">
    <div class="d-flex gap-3">
        <x-filters.date-range 
            form-id="filterForm"
            :auto-submit="false"
            :show-submit-button="true"
            submit-button-text="Apply Filter"
        />
    </div>
</form>
```

---

### 2. Status Filter Component

**Location**: `resources/views/components/filters/status-filter.blade.php`

#### Features
- Checkbox-based multi-select
- Custom status options
- Count display
- Clear function
- Auto-submit on apply (configurable)

#### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `formId` | string | 'filterForm' | Unique ID for component isolation |
| `statusFilter` | string | 'all' | Currently selected filter value |
| `statusOptions` | array | See below | Available status options |
| `totalCount` | integer | 0 | Total items count |
| `moduleLabel` | string | 'Items' | Label for module (e.g., "Goals", "Sales") |
| `autoSubmit` | boolean | true | Auto-submit form on apply |
| `parameterName` | string | 'filter' | Name attribute for the hidden input field |

#### Default Status Options

```php
[
    ['value' => 'all', 'label' => 'All'],
    ['value' => 'active', 'label' => 'Active'],
    ['value' => 'completed', 'label' => 'Completed']
]
```

#### Basic Usage

```blade
<form method="GET" action="{{ route('module.index') }}" id="filterForm">
    <div class="d-flex gap-3">
        <x-filters.status-filter 
            form-id="filterForm"
            :status-filter="request('filter', 'all')"
            :status-options="[
                ['value' => 'all', 'label' => 'All'],
                ['value' => 'active', 'label' => 'Active'],
                ['value' => 'pending', 'label' => 'Pending'],
                ['value' => 'completed', 'label' => 'Completed']
            ]"
            :total-count="$items->count()"
            module-label="Items"
        />
    </div>
</form>
```

---

## Usage Examples

### Example 1: Custom Parameter Name (User Management Module)

When your controller expects a different parameter name (e.g., `is_active` instead of `filter`):

```blade
<form method="GET" action="{{ route('users.index') }}" id="userFilterForm" class="mb-24 pb-24" style="border-bottom: 2px solid #e5e7eb;">
    <div class="d-flex flex-wrap align-items-center gap-3">
        <!-- Date Range Filter -->
        <x-filters.date-range 
            form-id="userFilterForm"
            :date-from="request('date_from')"
            :date-to="request('date_to')"
            :auto-submit="false"
        />

        <!-- Status Filter with Custom Parameter Name -->
        <x-filters.status-filter 
            form-id="userFilterForm"
            :status-filter="request('is_active', 'all')"
            :status-options="[
                ['value' => 'all', 'label' => 'All'],
                ['value' => '1', 'label' => 'Active'],
                ['value' => '0', 'label' => 'Inactive']
            ]"
            :total-count="$users->count()"
            module-label="Users"
            :auto-submit="false"
            parameter-name="is_active"
        />

        <!-- Apply Filter Button -->
        <button type="submit" class="btn btn-primary ms-auto">
            <i class="bi bi-filter"></i> Apply Filter
        </button>

        <!-- Reset Filter Button -->
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle"></i> Reset
        </a>
    </div>
</form>
```

### Example 2: Date Range Only (Stock Module)

```blade
<form method="GET" action="{{ route('stock.index') }}" id="stockFilterForm" class="mb-24">
    <div class="d-flex flex-wrap align-items-center gap-3">
        <!-- Date Range Filter Only -->
        <x-filters.date-range 
            form-id="stockFilterForm"
            :date-from="request('date_from', now()->startOfMonth()->format('Y-m-d'))"
            :date-to="request('date_to', now()->format('Y-m-d'))"
        />

        <!-- Custom Button using regular HTML -->
        <a href="{{ route('stock.create') }}" class="btn btn-primary ms-auto">
            <i class="bi bi-plus-circle"></i> Add Stock
        </a>
    </div>
</form>
```

### Example 3: Status Filter Only (Products Module)

```blade
<form method="GET" action="{{ route('products.index') }}" id="productFilterForm" class="mb-24">
    <div class="d-flex flex-wrap align-items-center gap-3">
        <!-- Status Filter Only -->
        <x-filters.status-filter 
            form-id="productFilterForm"
            :status-filter="request('filter', 'all')"
            :status-options="[
                ['value' => 'all', 'label' => 'All'],
                ['value' => 'active', 'label' => 'In Stock'],
                ['value' => 'low_stock', 'label' => 'Low Stock'],
                ['value' => 'out_of_stock', 'label' => 'Out of Stock']
            ]"
            :total-count="$products->count()"
            module-label="Products"
        />

        <a href="{{ route('products.create') }}" class="btn btn-primary ms-auto">
            <i class="bi bi-plus-circle"></i> Add Product
        </a>
    </div>
</form>
```

### Example 4: Both Filters Combined (Goals Module)

```blade
<form method="GET" action="{{ route('goals.index') }}" id="goalFilterForm" class="mb-24 pb-24" style="border-bottom: 2px solid #e5e7eb;">
    <div class="d-flex flex-wrap align-items-center gap-3">
        <!-- Date Range Filter -->
        <x-filters.date-range 
            form-id="goalFilterForm"
            :date-from="request('date_from', now()->startOfMonth()->format('Y-m-d'))"
            :date-to="request('date_to', now()->format('Y-m-d'))"
        />

        <!-- Status Filter -->
        <x-filters.status-filter 
            form-id="goalFilterForm"
            :status-filter="request('filter', 'all')"
            :status-options="[
                ['value' => 'all', 'label' => 'All'],
                ['value' => 'active', 'label' => 'Active'],
                ['value' => 'upcoming', 'label' => 'Upcoming'],
                ['value' => 'completed', 'label' => 'Completed']
            ]"
            :total-count="$goals->count()"
            module-label="Goals"
        />

        <!-- Refresh Button -->
        <button type="button" class="btn btn-outline-secondary" onclick="refreshData()">
            <i class="bi bi-arrow-clockwise"></i> Refresh
        </button>

        <!-- Create Button -->
        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#createGoalModal">
            <i class="bi bi-plus-circle"></i> Create Goal
        </button>
    </div>
</form>
```

### Example 5: Sales Module with Custom Layout

```blade
<form method="GET" action="{{ route('sales.index') }}" id="salesFilterForm" class="mb-24">
    <div class="row g-3">
        <!-- First Row: Date Range and Status -->
        <div class="col-12">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <x-filters.date-range 
                    form-id="salesFilterForm"
                    :date-from="request('date_from')"
                    :date-to="request('date_to')"
                />

                <x-filters.status-filter 
                    form-id="salesFilterForm"
                    :status-filter="request('filter', 'all')"
                    :status-options="[
                        ['value' => 'all', 'label' => 'All'],
                        ['value' => 'completed', 'label' => 'Completed'],
                        ['value' => 'pending', 'label' => 'Pending'],
                        ['value' => 'cancelled', 'label' => 'Cancelled']
                    ]"
                    :total-count="$sales->count()"
                    module-label="Sales"
                />
            </div>
        </div>

        <!-- Second Row: Additional Filters -->
        <div class="col-12">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <!-- Customer Filter -->
                <select name="customer_id" class="form-select" style="width: auto;">
                    <option value="">All Customers</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Channel Filter -->
                <select name="channel_id" class="form-select" style="width: auto;">
                    <option value="">All Channels</option>
                    @foreach($channels as $channel)
                        <option value="{{ $channel->id }}" {{ request('channel_id') == $channel->id ? 'selected' : '' }}>
                            {{ $channel->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Apply Button -->
                <button type="submit" class="btn btn-primary">
                    Apply Filters
                </button>

                <!-- Clear Button -->
                <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                    Clear
                </a>
            </div>
        </div>
    </div>
</form>
```

### Example 6: Expenses Module (No Auto-Submit)

```blade
<form method="GET" action="{{ route('expenses.index') }}" id="expenseFilterForm" class="mb-24">
    <div class="d-flex flex-wrap align-items-center gap-3">
        <x-filters.date-range 
            form-id="expenseFilterForm"
            :auto-submit="false"
            :show-submit-button="false"
        />

        <x-filters.status-filter 
            form-id="expenseFilterForm"
            :auto-submit="false"
            :status-options="[
                ['value' => 'all', 'label' => 'All'],
                ['value' => 'paid', 'label' => 'Paid'],
                ['value' => 'pending', 'label' => 'Pending'],
                ['value' => 'overdue', 'label' => 'Overdue']
            ]"
            module-label="Expenses"
        />

        <!-- Category Filter -->
        <select name="category_id" class="form-select" style="width: auto;">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <!-- Manual Submit -->
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-filter"></i> Apply Filters
        </button>
    </div>
</form>
```

## Benefits

### 1. **Flexibility**
- Use date filter alone
- Use status filter alone
- Use both together
- Add custom filters easily

### 2. **Modularity**
- Each component is independent
- No unused code loaded
- Easier to maintain
- Easier to extend

### 3. **Consistency**
- Same look and feel across all modules
- Predictable behavior
- Unified user experience

### 4. **Reusability**
- One codebase for all modules
- Bug fixes apply everywhere
- Features added once, available everywhere

### 5. **Customization**
- Auto-submit on/off per component
- Custom buttons alongside filters
- Custom layouts (row, column, etc.)
- Mix and match as needed

## Controller Integration

Both components work seamlessly with standard controller filtering:

```php
public function index(Request $request)
{
    // Date range filtering
    $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
    $dateTo = $request->get('date_to', now()->format('Y-m-d'));
    
    // Status filtering
    $filter = $request->get('filter', 'all');
    
    $query = YourModel::whereBetween('created_at', [$dateFrom, $dateTo]);
    
    if ($filter !== 'all') {
        $query->where('status', $filter);
    }
    
    $items = $query->get();
    
    return view('your-module.index', compact('items'));
}
```

## Migration from Old Component

If you were using the combined `date-and-status.blade.php` component:

### Old Way
```blade
<x-filters.date-and-status 
    :form-action="route('module.index')"
    form-id="filterForm"
    ...props...
/>
```

### New Way
```blade
<form method="GET" action="{{ route('module.index') }}" id="filterForm">
    <div class="d-flex gap-3">
        <x-filters.date-range form-id="filterForm" />
        <x-filters.status-filter form-id="filterForm" />
    </div>
</form>
```

## Notes

1. **Form ID**: Both components must use the same `form-id` when used together
2. **Auto-Submit**: Set to `false` if you want manual control
3. **Flatpickr**: Required for date range picker (already included in app)
4. **jQuery**: Required for both components (already included in app)
5. **Bootstrap 5**: Required for dropdowns and styling (already included in app)

---

**Created**: November 20, 2025  
**Status**: ✅ Ready for Use

