{{-- Product Edit Wizard --}}
<form action="{{ route('products.update', $product->id) }}" method="POST" id="editProductForm">
    @csrf
    @method('PUT')
    
    <!-- Hidden Fields -->
    <input type="hidden" name="is_active" value="{{ $product->is_active ? '1' : '0' }}" id="edit_hidden_is_active">
    <input type="hidden" name="additional_info" value="{{ $product->additional_info ?? '' }}">
    
    <!-- Progress Indicator -->
    <div class="mb-32">
        <div class="d-flex justify-content-between align-items-center mb-16">
            <div class="d-flex align-items-center gap-3 wizard-step-indicator" data-step="1">
                <div class="step-circle active" id="edit_circle_1">
                    <span>1</span>
                </div>
                <span class="fw-semibold text-sm step-label">Product Info</span>
            </div>
            <div class="progress-line" id="edit_line_1"></div>
            <div class="d-flex align-items-center gap-3 wizard-step-indicator" data-step="2">
                <div class="step-circle" id="edit_circle_2">
                    <span>2</span>
                </div>
                <span class="fw-semibold text-sm step-label">Pricing</span>
            </div>
            <div class="progress-line" id="edit_line_2"></div>
            <div class="d-flex align-items-center gap-3 wizard-step-indicator" data-step="3">
                <div class="step-circle" id="edit_circle_3">
                    <span>3</span>
                </div>
                <span class="fw-semibold text-sm step-label">Review</span>
            </div>
        </div>
        <div class="progress" style="height: 6px; border-radius: 10px; background-color: #e5e7eb;">
            <div class="progress-bar" id="edit_wizard_progress" role="progressbar" style="width: 33.33%; background-color: #ec3737; transition: width 0.3s ease;"></div>
        </div>
    </div>

    <!-- Wizard Steps Container -->
    <div id="edit_wizard_container">
        @include('products.partials.wizard.edit-step1-information')
        @include('products.partials.wizard.edit-step2-pricing')
        @include('products.partials.wizard.edit-step3-review')
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
    align-items-center;
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
    transition: color 0.3s ease;
}

.wizard-step-indicator:hover .step-label {
    color: #ec3737;
}

.step-circle.active + .step-label,
.step-circle.completed + .step-label {
    color: #374151 !important;
}

.progress-line {
    flex: 1;
    height: 2px;
    background-color: #e5e7eb;
    margin: 0 8px;
    transition: background-color 0.3s ease;
}

.progress-line.completed {
    background-color: #10b981;
}

.wizard-step {
    display: none;
}

.wizard-step.active {
    display: block;
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
(function() {
    'use strict';
    
    // Check if already initialized
    if (window.editProductWizardInit) {
        console.log('Edit Wizard already initialized, resetting...');
        if (typeof window.resetEditProductWizard === 'function') {
            window.resetEditProductWizard();
        }
        return;
    }
    
    let currentStep = 1;
    const totalSteps = 3;
    
    // Navigate to step
    function goToStep(step) {
        if (step < 1 || step > totalSteps) return;
        
        // Hide all steps
        $('#edit_wizard_container .wizard-step').removeClass('active');
        
        // Show target step
        $(`#edit_step_${step}`).addClass('active');
        
        // Update circles
        for (let i = 1; i <= totalSteps; i++) {
            const circle = $(`#edit_circle_${i}`);
            const line = $(`#edit_line_${i}`);
            
            if (i < step) {
                circle.removeClass('active').addClass('completed');
                line.addClass('completed');
            } else if (i === step) {
                circle.addClass('active').removeClass('completed');
            } else {
                circle.removeClass('active completed');
                line.removeClass('completed');
            }
        }
        
        // Update progress bar
        const progress = (step / totalSteps) * 100;
        $('#edit_wizard_progress').css('width', progress + '%');
        
        currentStep = step;
    }
    
    // Validate step
    function validateStep(step) {
        let isValid = true;
        let errors = [];
        
        if (step === 1) {
            const name = $('#edit_product_name').val().trim();
            if (!name) {
                errors.push('Product name is required');
                isValid = false;
            }
            
            const type = $('#edit_product_type').val();
            if (!type) {
                errors.push('Product type is required');
                isValid = false;
            }
        } else if (step === 2) {
            const price = parseFloat($('#edit_selling_price').val());
            if (!price || price <= 0) {
                errors.push('Valid selling price is required');
                isValid = false;
            }
        }
        
        if (!isValid) {
            alert('Please fix the following errors:\n\n' + errors.join('\n'));
        }
        
        return isValid;
    }
    
    // Update review step
    window.updateEditProductReview = function() {
        // Product info
        $('#edit_review_product_name').text($('#edit_product_name').val() || 'N/A');
        $('#edit_review_sku').text($('#edit_sku').val() || 'Auto-generated');
        $('#edit_review_category').text($('#edit_product_category_id option:selected').text() || 'No Category');
        $('#edit_review_type').text($('#edit_product_type option:selected').text() || 'N/A');
        $('#edit_review_description').text($('#edit_description').val() || 'No description');
        
        // Pricing info
        const currency = "{{ auth()->user()->business->currency }}";
        const price = parseFloat($('#edit_selling_price').val()) || 0;
        const tax = parseFloat($('#edit_tax_amount').val()) || 0;
        const cost = parseFloat($('#edit_cost').val()) || 0;
        const totalCost = cost + tax;
        const profit = price - totalCost;
        const margin = totalCost > 0 ? ((profit / totalCost) * 100).toFixed(2) : 0;
        
        $('#edit_review_price').text(currency + ' ' + price.toFixed(2));
        $('#edit_review_cost').text(currency + ' ' + cost.toFixed(2));
        $('#edit_review_tax').text(currency + ' ' + tax.toFixed(2));
        $('#edit_review_total_cost').text(currency + ' ' + totalCost.toFixed(2));
        $('#edit_review_profit').text(currency + ' ' + profit.toFixed(2));
        $('#edit_review_margin').text(margin + '%');
        
        // Stock info
        const stock = $('#edit_stock_quantity').val() || 0;
        const unit = $('#edit_unit_of_measurement option:selected').text() || 'Units';
        const minStock = $('#edit_min_stock_alert').val() || 0;
        const status = $('#edit_product_status').prop('checked') ? 'Active' : 'Inactive';
        
        $('#edit_review_stock').text(stock + ' ' + unit);
        $('#edit_review_unit').text(unit);
        $('#edit_review_min_stock').text(minStock + ' ' + unit);
        $('#edit_review_status').html(status === 'Active' ? 
            '<span class="badge bg-success-100 text-success-600 px-16 py-6">Active</span>' :
            '<span class="badge bg-danger-100 text-danger-600 px-16 py-6">Inactive</span>'
        );
    };
    
    // Event handlers using delegation
    $(document).off('click.editWizardNav').on('click.editWizardNav', '#edit_wizard_container .btn-next-step', function(e) {
        e.preventDefault();
        if (validateStep(currentStep)) {
            if (currentStep === totalSteps - 1) {
                window.updateEditProductReview();
            }
            goToStep(currentStep + 1);
        }
    });
    
    $(document).off('click.editWizardBack').on('click.editWizardBack', '#edit_wizard_container .btn-prev-step', function(e) {
        e.preventDefault();
        goToStep(currentStep - 1);
    });
    
    $(document).off('click.editWizardIndicator').on('click.editWizardIndicator', '#editProductForm .wizard-step-indicator', function() {
        const targetStep = parseInt($(this).data('step'));
        if (targetStep < currentStep || validateStep(currentStep)) {
            if (targetStep === totalSteps) {
                window.updateEditProductReview();
            }
            goToStep(targetStep);
        }
    });
    
    $(document).off('change.editAutoSKU').on('change.editAutoSKU', '#edit_auto_generate_sku', function() {
        $('#edit_sku').prop('disabled', this.checked);
        if (this.checked) {
            $('#edit_sku').val('');
        }
    });
    
    $(document).off('change.editProductStatus').on('change.editProductStatus', '#edit_product_status', function() {
        $('#edit_hidden_is_active').val(this.checked ? '1' : '0');
    });
    
    $(document).off('click.editEditStep').on('click.editEditStep', '#edit_wizard_container .btn-edit-step', function(e) {
        e.preventDefault();
        const step = parseInt($(this).data('step'));
        goToStep(step);
    });
    
    // Reset function
    window.resetEditProductWizard = function() {
        currentStep = 1;
        goToStep(1);
        window.editProductWizardInit = false;
    };
    
    // Initialize
    goToStep(1);
    
    window.editProductWizardInit = true;
    
})();
</script>

