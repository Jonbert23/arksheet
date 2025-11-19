{{-- Product Creation Wizard --}}
<form action="{{ route('products.store') }}" method="POST" id="createProductForm">
    @csrf
    
    <!-- Hidden Fields -->
    <input type="hidden" name="is_active" value="1" id="hidden_is_active">
    <input type="hidden" name="additional_info" value="">
    
    <!-- Progress Indicator -->
    <div class="mb-32">
        <div class="d-flex justify-content-between align-items-center mb-16">
            <div class="d-flex align-items-center gap-3 wizard-step-indicator" data-step="1">
                <div class="step-circle active" id="circle_1">
                    <span>1</span>
                </div>
                <span class="fw-semibold text-sm step-label">Product Info</span>
            </div>
            <div class="progress-line" id="line_1"></div>
            <div class="d-flex align-items-center gap-3 wizard-step-indicator" data-step="2">
                <div class="step-circle" id="circle_2">
                    <span>2</span>
                </div>
                <span class="fw-semibold text-sm step-label">Pricing</span>
            </div>
            <div class="progress-line" id="line_2"></div>
            <div class="d-flex align-items-center gap-3 wizard-step-indicator" data-step="3">
                <div class="step-circle" id="circle_3">
                    <span>3</span>
                </div>
                <span class="fw-semibold text-sm step-label">Stock</span>
            </div>
            <div class="progress-line" id="line_3"></div>
            <div class="d-flex align-items-center gap-3 wizard-step-indicator" data-step="4">
                <div class="step-circle" id="circle_4">
                    <span>4</span>
                </div>
                <span class="fw-semibold text-sm step-label">Review</span>
            </div>
        </div>
        <div class="progress" style="height: 6px; border-radius: 10px; background-color: #e5e7eb;">
            <div class="progress-bar" id="wizard_progress" role="progressbar" style="width: 25%; background-color: #ec3737; transition: width 0.3s ease;"></div>
        </div>
    </div>

    <!-- Wizard Steps Container -->
    <div id="wizard_container">
        @include('products.partials.wizard.step1-information')
        @include('products.partials.wizard.step2-pricing')
        @include('products.partials.wizard.step3-stock')
        @include('products.partials.wizard.step4-review')
    </div>
</form>

<style>
/* Wizard Progress Styles */
.wizard-step-indicator {
    cursor: pointer;
    transition: all 0.3s ease;
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e5e7eb;
    color: #9ca3af;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    border: 3px solid transparent;
}

.step-circle.active {
    background-color: #ec3737;
    color: white;
    border-color: #fca5a5;
    box-shadow: 0 0 0 4px rgba(236, 55, 55, 0.1);
}

.step-circle.completed {
    background-color: #10b981;
    color: white;
    border-color: #86efac;
}

.step-circle.completed span {
    display: none;
}

.step-circle.completed::before {
    content: "✓";
    font-size: 20px;
    font-weight: bold;
}

.step-label {
    color: #9ca3af;
    transition: all 0.3s ease;
}

.wizard-step-indicator[data-step] .step-circle.active ~ .step-label,
.wizard-step-indicator[data-step] .step-circle.completed ~ .step-label {
    color: #1f2937;
}

.progress-line {
    flex: 1;
    height: 3px;
    background-color: #e5e7eb;
    transition: all 0.3s ease;
}

.progress-line.completed {
    background-color: #10b981;
}

.wizard-step {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>

<script>
// Consolidated Product Wizard JavaScript - Wrapped in IIFE to prevent redeclaration
(function() {
    'use strict';
    
    // Check if already initialized
    if (window.productWizardInit) {
        console.log('Wizard already initialized, resetting...');
        if (typeof window.resetProductWizard === 'function') {
            window.resetProductWizard();
        }
        return;
    }
    
    let currentStep = 1;
    const totalSteps = 4;
    
    // Navigate to step
    function goToStep(step) {
        if (step < 1 || step > totalSteps) return;
        
        $('.wizard-step').hide();
        $(`#step${step}`).show();
        
        const progress = (step / totalSteps) * 100;
        $('#wizard_progress').css('width', progress + '%');
        
        for (let i = 1; i <= totalSteps; i++) {
            const $circle = $(`#circle_${i}`);
            const $line = $(`#line_${i}`);
            
            if (i < step) {
                $circle.addClass('completed').removeClass('active');
                $line.addClass('completed');
            } else if (i === step) {
                $circle.addClass('active').removeClass('completed');
            } else {
                $circle.removeClass('active completed');
                $line.removeClass('completed');
            }
        }
        
        if (step === 4 && typeof window.updateProductReview === 'function') {
            window.updateProductReview();
        }
        
        $('.modal-body').scrollTop(0);
        currentStep = step;
    }
    
    // Validate step
    function validateStep(step) {
        if (step === 1) {
            const name = $('#product_name').val().trim();
            const category = $('#product_category').val();
            const type = $('#product_type').val();
            
            if (!name) { alert('Please enter a product name'); return false; }
            if (!category) { alert('Please select a product category'); return false; }
            if (!type) { alert('Please select a product type'); return false; }
        } else if (step === 2) {
            const price = parseFloat($('#selling_price').val());
            const unit = $('#unit_of_measurement').val();
            
            if (!price || price <= 0) { alert('Please enter a valid selling price'); return false; }
            if (!unit) { alert('Please select a unit of measurement'); return false; }
        } else if (step === 3) {
            const addStock = $('input[name="add_stock_option"]:checked').val() === 'yes';
            
            if (addStock) {
                const quantity = parseFloat($('#quantity_received').val());
                const costPerUnit = parseFloat($('#cost_per_unit').val());
                
                if (!quantity || quantity <= 0) { alert('Please enter a valid quantity'); return false; }
                if (!costPerUnit || costPerUnit < 0) { alert('Please enter a valid cost per unit'); return false; }
            }
        }
        
        return true;
    }
    
    // Calculate costs
    function calculateCosts() {
        const quantity = parseFloat($('#quantity_received').val()) || 0;
        const costPerUnit = parseFloat($('#cost_per_unit').val()) || 0;
        const shipping = parseFloat($('#shipping_cost').val()) || 0;
        const duties = parseFloat($('#import_duties').val()) || 0;
        const other = parseFloat($('#other_costs').val()) || 0;

        const subtotal = quantity * costPerUnit;
        const totalAdditional = shipping + duties + other;
        const totalCost = subtotal + totalAdditional;
        const actualCostPerUnit = quantity > 0 ? totalCost / quantity : 0;

        $('#breakdown_quantity').text(quantity);
        $('#breakdown_cost_per_unit').text(costPerUnit.toFixed(2));
        $('#breakdown_subtotal').text(subtotal.toFixed(2));
        $('#breakdown_shipping').text(shipping.toFixed(2));
        $('#breakdown_duties').text(duties.toFixed(2));
        $('#breakdown_other').text(other.toFixed(2));
        $('#breakdown_total_cost').text(totalCost.toFixed(2));
        $('#breakdown_actual_cost').text(actualCostPerUnit.toFixed(2));
        $('#total_additional_costs').text('{{ auth()->user()->business->currency }} ' + totalAdditional.toFixed(2));
    }
    
    // Update review step
    window.updateProductReview = function() {
        const currency = '{{ auth()->user()->business->currency }}';
        
        // Product Information
        $('#review_name').text($('#product_name').val() || '-');
        $('#review_sku').text($('#product_sku').val() || '-');
        $('#review_category').text($('#product_category option:selected').text() || '-');
        $('#review_type').text($('#product_type option:selected').text() || '-');
        $('#review_description').text($('#product_description').val() || 'No description provided');

        // Pricing & Settings
        const sellingPrice = parseFloat($('#selling_price').val()) || 0;
        const taxAmount = parseFloat($('#tax_amount').val()) || 0;
        $('#review_price').text(`${currency} ${sellingPrice.toFixed(2)}`);
        $('#review_tax').text(`${currency} ${taxAmount.toFixed(2)}`);
        $('#review_unit').text($('#unit_of_measurement option:selected').text() || '-');
        $('#review_min_stock').text(($('#min_stock_alert').val() || '10') + ' units');
        $('#review_status').text($('#product_status').is(':checked') ? '✓ Active' : '✗ Inactive');

        // Stock Entry
        const addStock = $('input[name="add_stock_option"]:checked').val() === 'yes';
        
        if (addStock) {
            $('#review_stock_added').show();
            $('#review_stock_skipped').hide();
            $('#profit_analysis').show();

            const quantity = parseFloat($('#quantity_received').val()) || 0;
            const costPerUnit = parseFloat($('#cost_per_unit').val()) || 0;
            const shipping = parseFloat($('#shipping_cost').val()) || 0;
            const duties = parseFloat($('#import_duties').val()) || 0;
            const other = parseFloat($('#other_costs').val()) || 0;
            const totalAdditional = shipping + duties + other;
            const totalCost = (quantity * costPerUnit) + totalAdditional;
            const actualCostPerUnit = quantity > 0 ? totalCost / quantity : 0;

            const unit = $('#unit_of_measurement option:selected').text().match(/\((.*?)\)/)?.[1] || 'pcs';

            $('#review_stock_date').text($('#date_received').val() || '-');
            $('#review_stock_quantity').text(`${quantity} ${unit}`);
            $('#review_stock_cost').text(`${currency} ${costPerUnit.toFixed(2)}`);
            $('#review_stock_additional').text(`${currency} ${totalAdditional.toFixed(2)}`);
            $('#review_stock_total').text(`${currency} ${totalCost.toFixed(2)}`);
            $('#review_stock_actual_cost').text(`${currency} ${actualCostPerUnit.toFixed(2)}`);
            $('#review_stock_supplier').text($('#supplier').val() || 'Not specified');
            $('#review_stock_reference').text($('#reference_number').val() || 'Not specified');

            // Profit Analysis
            const profitPerUnit = sellingPrice - actualCostPerUnit;
            const profitMargin = sellingPrice > 0 ? (profitPerUnit / sellingPrice) * 100 : 0;

            $('#profit_selling_price').text(`${currency} ${sellingPrice.toFixed(2)}`);
            $('#profit_unit_cost').text(`${currency} ${actualCostPerUnit.toFixed(2)}`);
            $('#profit_per_unit').text(`${currency} ${profitPerUnit.toFixed(2)}`);
            $('#profit_margin_value').text(profitMargin.toFixed(2));
            
            // Show check icon if profit margin is positive
            $('#profit_icon').toggle(profitMargin > 0);
        } else {
            $('#review_stock_added').hide();
            $('#review_stock_skipped').show();
            $('#profit_analysis').hide();
        }
    };
    
    // Event handlers using delegation
    $(document).off('click.wizardNav').on('click.wizardNav', '.btn-next-step', function(e) {
        e.preventDefault();
        const nextStep = parseInt($(this).data('next-step'));
        if (validateStep(currentStep)) {
            goToStep(nextStep);
        }
    });
    
    $(document).off('click.wizardBack').on('click.wizardBack', '.btn-prev-step', function(e) {
        e.preventDefault();
        const prevStep = parseInt($(this).data('prev-step'));
        goToStep(prevStep);
    });
    
    $(document).off('click.wizardIndicator').on('click.wizardIndicator', '.wizard-step-indicator', function() {
        const step = parseInt($(this).data('step'));
        if (step <= currentStep) {
            goToStep(step);
        }
    });
    
    // Auto-generate SKU
    $(document).off('change.autoSKU').on('change.autoSKU', '#auto_generate_sku', function() {
        const $skuInput = $('#product_sku');
        if (this.checked) {
            $skuInput.val('SKU-' + Math.random().toString(36).substr(2, 9).toUpperCase()).prop('readOnly', true);
        } else {
            $skuInput.prop('readOnly', false);
        }
    });
    
    // Status toggle
    $(document).off('change.productStatus').on('change.productStatus', '#product_status', function() {
        $('#status_label').text(this.checked ? 'Active' : 'Inactive');
        $('#hidden_is_active').val(this.checked ? '1' : '0');
    });
    
    // Stock option toggle
    $(document).off('change.stockOption').on('change.stockOption', 'input[name="add_stock_option"]', function() {
        const $stockForm = $('#stock_entry_form');
        const $skipMessage = $('#skip_message');
        
        if (this.value === 'yes') {
            $stockForm.show().find('input, textarea, select').prop('disabled', false);
            $skipMessage.hide();
        } else {
            $stockForm.hide().find('input, textarea, select').prop('disabled', true);
            $skipMessage.show();
        }
    });
    
    // Cost calculation
    $(document).off('input.costCalc').on('input.costCalc', '#quantity_received, #cost_per_unit, #shipping_cost, #import_duties, #other_costs', calculateCosts);
    
    // Unit change
    $(document).off('change.unitUpdate').on('change.unitUpdate', '#unit_of_measurement', function() {
        const unitText = $(this).find('option:selected').text().match(/\((.*?)\)/)?.[1] || 'pcs';
        $('#quantity_unit, #breakdown_unit').text(unitText);
    });
    
    // Collapse toggle
    $(document).off('click.collapseToggle').on('click.collapseToggle', '[data-bs-toggle="collapse"]', function() {
        setTimeout(() => {
            $('#collapse_icon').toggleClass('bi-chevron-down bi-chevron-up');
        }, 100);
    });
    
    // Edit step buttons in review
    $(document).off('click.editStep').on('click.editStep', '.btn-edit-step', function(e) {
        e.preventDefault();
        const stepNum = parseInt($(this).data('edit-step'));
        goToStep(stepNum);
    });
    
    // Reset function
    window.resetProductWizard = function() {
        goToStep(1);
        $('#stock_entry_form').find('input, textarea, select').prop('disabled', true);
    };
    
    // Initialize
    goToStep(1);
    $('#stock_entry_form').find('input, textarea, select').prop('disabled', true);
    
    window.productWizardInit = true;
    
})();
</script>


