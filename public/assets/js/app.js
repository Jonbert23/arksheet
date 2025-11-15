(function ($) {
  'use strict';

  // sidebar submenu collapsible js - DISABLED (using inline onclick instead)
  // See sidebar.blade.php for the toggleDropdown() function

  $(".sidebar-toggle").on("click", function(){
    $(this).toggleClass("active");
    $(".sidebar").toggleClass("active");
    $(".dashboard-main").toggleClass("active");
  });

  $(".sidebar-mobile-toggle").on("click", function(){
    $(".sidebar").addClass("sidebar-open");
    $("body").addClass("overlay-active");
  });

  $(".sidebar-close-btn").on("click", function(){
    $(".sidebar").removeClass("sidebar-open");
    $("body").removeClass("overlay-active");
  });

  //to keep the current page active
  $(function () {
    for (
      var nk = window.location,
        o = $("ul#sidebar-menu a")
          .filter(function () {
            return this.href == nk;
          })
          .addClass("active-page") // anchor
          .parent()
          .addClass("active-page");
      ;

    ) {
      // li
      if (!o.is("li")) break;
      o = o.parent().addClass("show").parent().addClass("open");
    }
  });

/**
* Utility function to calculate the current theme setting based on localStorage.
*/
function calculateSettingAsThemeString({ localStorageTheme }) {
  if (localStorageTheme !== null) {
    return localStorageTheme;
  }
  return "light"; // default to light theme if nothing is stored
}

/**
* Utility function to update the button text and aria-label.
*/
function updateButton({ buttonEl, isDark }) {
  const newCta = isDark ? "dark" : "light";
  buttonEl.setAttribute("aria-label", newCta);
  buttonEl.innerText = newCta;
}

/**
* Utility function to update the theme setting on the html tag.
*/
function updateThemeOnHtmlEl({ theme }) {
  document.querySelector("html").setAttribute("data-theme", theme);
}

/**
* 1. Grab what we need from the DOM and system settings on page load.
*/
const button = document.querySelector("[data-theme-toggle]");
const localStorageTheme = localStorage.getItem("theme");

/**
* 2. Work out the current site settings.
*/
let currentThemeSetting = calculateSettingAsThemeString({ localStorageTheme });

/**
* 3. If the button exists, update the theme setting and button text according to current settings.
*/
if (button) {
  updateButton({ buttonEl: button, isDark: currentThemeSetting === "dark" });
  updateThemeOnHtmlEl({ theme: currentThemeSetting });

  /**
  * 4. Add an event listener to toggle the theme.
  */
  button.addEventListener("click", (event) => {
    const newTheme = currentThemeSetting === "dark" ? "light" : "dark";

    localStorage.setItem("theme", newTheme);
    updateButton({ buttonEl: button, isDark: newTheme === "dark" });
    updateThemeOnHtmlEl({ theme: newTheme });

    currentThemeSetting = newTheme;
  });
} else {
  // If no button is found, just apply the current theme to the page
  updateThemeOnHtmlEl({ theme: currentThemeSetting });
}


// =========================== Table Header Checkbox checked all js Start ================================
$('#selectAll').on('change', function () {
  $('.form-check .form-check-input').prop('checked', $(this).prop('checked')); 
}); 

  // Remove Table Tr when click on remove btn start
  $('.remove-btn').on('click', function () {
    $(this).closest('tr').remove(); 

    // Check if the table has no rows left
    if ($('.table tbody tr').length === 0) {
      $('.table').addClass('bg-danger');

      // Show notification
      $('.no-items-found').show();
    }
  });
  // Remove Table Tr when click on remove btn end
})(jQuery);

// ======================== Global Date Range Picker Utility ========================
/**
 * Initialize a branded date range picker with Flatpickr
 * 
 * @param {Object} options - Configuration options
 * @param {string} options.inputSelector - CSS selector for the input field (e.g., "#date_range")
 * @param {string} options.startDateInputId - ID of hidden input for start date (e.g., "start_date")
 * @param {string} options.endDateInputId - ID of hidden input for end date (e.g., "end_date")
 * @param {Array|null} options.defaultDates - Default date range [startDate, endDate] or null
 * @param {Function|null} options.onChangeCallback - Optional callback when dates change
 * @param {Object} options.flatpickrOptions - Additional Flatpickr options to override defaults
 * @returns {Object} Flatpickr instance
 * 
 * @example
 * // Basic usage with auto-generated dates (today + 1 month)
 * initDateRangePicker({
 *   inputSelector: '#create_date_range',
 *   startDateInputId: 'create_start_date',
 *   endDateInputId: 'create_end_date'
 * });
 * 
 * @example
 * // With existing dates
 * initDateRangePicker({
 *   inputSelector: '#edit_date_range',
 *   startDateInputId: 'edit_start_date',
 *   endDateInputId: 'edit_end_date',
 *   defaultDates: ['2025-01-01', '2025-01-31']
 * });
 * 
 * @example
 * // With custom callback
 * initDateRangePicker({
 *   inputSelector: '#custom_date_range',
 *   startDateInputId: 'start_date',
 *   endDateInputId: 'end_date',
 *   onChangeCallback: function(selectedDates) {
 *     console.log('Dates changed:', selectedDates);
 *   }
 * });
 */
window.initDateRangePicker = function(options) {
  // Validate required parameters
  if (!options.inputSelector) {
    console.error('initDateRangePicker: inputSelector is required');
    return null;
  }
  if (!options.startDateInputId || !options.endDateInputId) {
    console.error('initDateRangePicker: startDateInputId and endDateInputId are required');
    return null;
  }

  // Check if element exists
  const inputElement = document.querySelector(options.inputSelector);
  if (!inputElement) {
    console.error(`initDateRangePicker: Element ${options.inputSelector} not found`);
    return null;
  }

  // Helper function to format date for hidden inputs (YYYY-MM-DD)
  const formatDateForInput = function(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  };

  // Set default dates if not provided
  let defaultDates = options.defaultDates;
  if (!defaultDates || defaultDates.length === 0) {
    const today = new Date();
    const nextMonth = new Date();
    nextMonth.setMonth(nextMonth.getMonth() + 1);
    defaultDates = [today, nextMonth];
  }

  // Base Flatpickr configuration with branded styling
  const baseConfig = {
    mode: "range",
    dateFormat: "M d, Y",
    defaultDate: defaultDates,
    onChange: function(selectedDates, dateStr, instance) {
      if (selectedDates.length === 2) {
        const startInput = document.getElementById(options.startDateInputId);
        const endInput = document.getElementById(options.endDateInputId);
        
        if (startInput && endInput) {
          startInput.value = formatDateForInput(selectedDates[0]);
          endInput.value = formatDateForInput(selectedDates[1]);
        }

        // Call custom callback if provided
        if (typeof options.onChangeCallback === 'function') {
          options.onChangeCallback(selectedDates, dateStr, instance);
        }
      }
    },
    onReady: function(selectedDates, dateStr, instance) {
      // Set initial values on ready
      if (selectedDates.length === 2) {
        const startInput = document.getElementById(options.startDateInputId);
        const endInput = document.getElementById(options.endDateInputId);
        
        if (startInput && endInput) {
          startInput.value = formatDateForInput(selectedDates[0]);
          endInput.value = formatDateForInput(selectedDates[1]);
        }
      }
    }
  };

  // Merge custom Flatpickr options if provided
  const finalConfig = options.flatpickrOptions 
    ? { ...baseConfig, ...options.flatpickrOptions }
    : baseConfig;

  // Initialize and return Flatpickr instance
  return flatpickr(options.inputSelector, finalConfig);
};

/**
 * Helper function to format date for display (YYYY-MM-DD)
 * Exposed globally for backward compatibility
 */
window.formatDateForInput = function(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
};