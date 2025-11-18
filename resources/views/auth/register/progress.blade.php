{{-- Registration Progress Indicator --}}
<div class="registration-progress mb-40">
    {{-- Progress Bar --}}
    <div class="progress-bar-wrapper">
        <div class="progress-fill" style="width: {{ ($currentStep / 4) * 100 }}%;"></div>
    </div>
    
    {{-- Step Indicators --}}
    <div class="progress-steps">
        <div class="progress-step {{ $currentStep >= 1 ? 'active' : '' }}">
            <div class="step-circle">
                @if($currentStep > 1)
                    <iconify-icon icon="solar:check-circle-bold" width="20"></iconify-icon>
                @else
                    1
                @endif
            </div>
            <span class="step-label">Business</span>
        </div>
        
        <div class="progress-step {{ $currentStep >= 2 ? 'active' : '' }}">
            <div class="step-circle">
                @if($currentStep > 2)
                    <iconify-icon icon="solar:check-circle-bold" width="20"></iconify-icon>
                @else
                    2
                @endif
            </div>
            <span class="step-label">Account</span>
        </div>
        
        <div class="progress-step {{ $currentStep >= 3 ? 'active' : '' }}">
            <div class="step-circle">
                @if($currentStep > 3)
                    <iconify-icon icon="solar:check-circle-bold" width="20"></iconify-icon>
                @else
                    3
                @endif
            </div>
            <span class="step-label">Location</span>
        </div>
        
        <div class="progress-step {{ $currentStep >= 4 ? 'active' : '' }}">
            <div class="step-circle">4</div>
            <span class="step-label">Finalize</span>
        </div>
    </div>
</div>

<style>
    .registration-progress {
        margin-bottom: 40px;
    }
    
    .progress-bar-wrapper {
        width: 100%;
        height: 4px;
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    .progress-fill {
        height: 100%;
        background: #ec3737;
        transition: width 0.4s ease;
    }
    
    .progress-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        flex: 1;
    }
    
    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f0f0f0;
        color: #999;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .progress-step.active .step-circle {
        background: #ec3737;
        color: white;
    }
    
    .step-label {
        font-size: 12px;
        color: #999;
        font-weight: 500;
    }
    
    .progress-step.active .step-label {
        color: #ec3737;
        font-weight: 600;
    }
    
    @media (max-width: 576px) {
        .step-circle {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
        
        .step-label {
            font-size: 10px;
        }
    }
</style>

