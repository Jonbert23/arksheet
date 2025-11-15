# Global Date Range Picker Utility

A reusable, branded date range picker utility for the ArkSheet application using Flatpickr.

## Location
- **Utility Function**: `public/assets/js/app.js`
- **Global Function**: `window.initDateRangePicker()`

## Features
- ✅ Branded styling with red gradient header
- ✅ White navigation arrows
- ✅ Automatic date formatting (YYYY-MM-DD)
- ✅ Hidden input fields auto-population
- ✅ Customizable default dates
- ✅ Optional change callbacks
- ✅ Error handling and validation
- ✅ Works with AJAX-loaded content

## Basic Usage

### Example 1: Create Form (Auto-generated dates)
```javascript
// Automatically sets range from today to +1 month
initDateRangePicker({
    inputSelector: '#create_date_range',
    startDateInputId: 'create_start_date',
    endDateInputId: 'create_end_date'
});
```

### Example 2: Edit Form (Existing dates)
```javascript
// Pre-fill with existing dates
const startDate = document.getElementById('edit_start_date').value;
const endDate = document.getElementById('edit_end_date').value;

initDateRangePicker({
    inputSelector: '#edit_date_range',
    startDateInputId: 'edit_start_date',
    endDateInputId: 'edit_end_date',
    defaultDates: [startDate, endDate]
});
```

### Example 3: Custom Callback
```javascript
// Execute custom logic when dates change
initDateRangePicker({
    inputSelector: '#custom_date_range',
    startDateInputId: 'start_date',
    endDateInputId: 'end_date',
    onChangeCallback: function(selectedDates, dateStr, instance) {
        console.log('Selected dates:', selectedDates);
        // Trigger API call, update UI, etc.
    }
});
```

### Example 4: Custom Flatpickr Options
```javascript
// Override default Flatpickr options
initDateRangePicker({
    inputSelector: '#date_range',
    startDateInputId: 'start_date',
    endDateInputId: 'end_date',
    flatpickrOptions: {
        minDate: 'today',
        maxDate: new Date().fp_incr(365), // Max 1 year ahead
        disable: [
            function(date) {
                // Disable weekends
                return (date.getDay() === 0 || date.getDay() === 6);
            }
        ]
    }
});
```

## Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `inputSelector` | String | Yes | CSS selector for the visible input field |
| `startDateInputId` | String | Yes | ID of the hidden input for start date |
| `endDateInputId` | String | Yes | ID of the hidden input for end date |
| `defaultDates` | Array | No | Array of 2 dates [start, end]. Defaults to [today, today+1month] |
| `onChangeCallback` | Function | No | Custom callback function when dates change |
| `flatpickrOptions` | Object | No | Additional Flatpickr configuration options |

## HTML Structure Required

```html
<!-- Visible input field with calendar icon -->
<div class="input-group date-range-input-group">
    <span class="input-group-text bg-white border-end-0">
        <iconify-icon icon="mdi:calendar-range" style="font-size: 18px; color: #ec3737;"></iconify-icon>
    </span>
    <input type="text" 
           class="form-control border-start-0" 
           id="date_range" 
           placeholder="Select start and end date" 
           readonly>
</div>

<!-- Hidden inputs for form submission -->
<input type="hidden" id="start_date" name="start_date">
<input type="hidden" id="end_date" name="end_date">
```

## CSS Styling (Already included in partials)

The styled calendar requires the CSS found in:
- `resources/views/goals/partials/create-form.blade.php`
- `resources/views/goals/partials/edit-form.blade.php`

Copy the `<style>` block to your own forms or extract to a global CSS file.

## AJAX Integration

When loading forms via AJAX, initialize the picker after content loads:

```javascript
$.ajax({
    url: '/your-form-url',
    type: 'GET',
    success: function(response) {
        $('#modalBody').html(response);
        
        // Initialize after DOM is ready
        setTimeout(function() {
            initDateRangePicker({
                inputSelector: '#date_range',
                startDateInputId: 'start_date',
                endDateInputId: 'end_date'
            });
        }, 100);
    }
});
```

## Helper Function

A helper function is also exposed globally for date formatting:

```javascript
const formatted = formatDateForInput(new Date());
// Returns: "2025-01-15" (YYYY-MM-DD)
```

## Error Handling

The utility includes built-in validation:
- Checks if required parameters are provided
- Validates element existence
- Logs errors to console
- Returns `null` if initialization fails

```javascript
const picker = initDateRangePicker({
    inputSelector: '#nonexistent',
    startDateInputId: 'start',
    endDateInputId: 'end'
});

if (!picker) {
    console.log('Failed to initialize date range picker');
    // Handle error
}
```

## Current Implementations

This utility is currently used in:
1. **Goals Module** - Create Goal Modal
2. **Goals Module** - Edit Goal Modal

## Future Usage

To use in other modules (e.g., Reports, Expenses, Tasks):

1. Add the HTML structure to your form
2. Include the CSS styling (or move to global CSS)
3. Call `initDateRangePicker()` after form loads
4. Customize options as needed

## Dependencies

- **Flatpickr**: Must be loaded before calling this utility
- **jQuery**: Used in AJAX examples (optional for core utility)

## Browser Support

Works in all modern browsers that support:
- ES6 JavaScript
- Flatpickr library
- CSS Grid and Flexbox

