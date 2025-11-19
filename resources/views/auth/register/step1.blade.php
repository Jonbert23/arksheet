<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Business Account - Step 1 | ArkSheets</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: -20%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            z-index: 0;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -15%;
            right: -5%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            z-index: 0;
        }
        .page-container {
            width: 90%;
            max-width: 1200px;
            background: #ffffff;
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            height: 85vh;
            max-height: 700px;
            position: relative;
            z-index: 1;
            margin: 40px 0;
        }
        .auth-container {
            display: flex;
            height: 100%;
        }
        .auth-form-section {
            flex: 1;
            padding: 40px 50px;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            background: #ffffff;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .auth-form-section::-webkit-scrollbar {
            width: 6px;
        }
        .auth-form-section::-webkit-scrollbar-thumb {
            background: #e0e0e0;
            border-radius: 3px;
        }
        .auth-form-section::-webkit-scrollbar-track {
            background: #f9fafb;
        }
        .form-card {
            width: 100%;
            max-width: 420px;
            padding: 20px 0;
        }
        .auth-announcements-section {
            flex: 1;
            padding: 40px 50px;
            background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .auth-announcements-section::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -15%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        .announcements-container {
            max-width: 500px;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        .auth-title {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .auth-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 18px;
            width: 100%;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-input, .form-select {
            width: 100%;
            padding: 13px 16px;
            font-size: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f9fafb;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #ec3737;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(236, 55, 55, 0.1);
        }
        .btn-primary {
            width: 100%;
            padding: 14px;
            background: #ec3737;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #d42f2f;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(236, 55, 55, 0.4);
        }
        .announcement-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .announcement-title {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 14px;
            line-height: 1.3;
        }
        .announcement-subtitle {
            font-size: 14px;
            opacity: 0.92;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .progress-step-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            margin-bottom: 12px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        .progress-step-item .step-number {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }
        .progress-step-item.active {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
        }
        .progress-step-item.active .step-number {
            background: white;
            color: #ec3737;
        }
        @media (max-width: 768px) {
            .auth-announcements-section {
                display: none;
            }
            .page-container {
                max-height: none;
            }
        }
    </style>
</head>
<body>

    <div class="page-container">
        <div class="auth-container">
            {{-- Announcements Section --}}
            <div class="auth-announcements-section">
                <div class="announcements-container">
                    <div class="announcement-badge">
                        <i class="bi bi-circle-fill"></i>
                        Registration Progress
                    </div>
                    
                    <h2 class="announcement-title">4 Simple Steps to Get Started</h2>
                    <p class="announcement-subtitle">Complete your business registration in just a few minutes and start managing your inventory, sales, and finances.</p>

                    <div style="margin-top: 32px;">
                        <div class="progress-step-item active">
                            <div class="step-number">1</div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 2px;">Business Information</div>
                                <div style="font-size: 13px; opacity: 0.85;">Company details & preferences</div>
                            </div>
                        </div>

                        <div class="progress-step-item">
                            <div class="step-number">2</div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 2px;">Owner Account</div>
                                <div style="font-size: 13px; opacity: 0.85;">Create your admin account</div>
                            </div>
                        </div>

                        <div class="progress-step-item">
                            <div class="step-number">3</div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 2px;">Business Location</div>
                                <div style="font-size: 13px; opacity: 0.85;">Address & timezone settings</div>
                            </div>
                        </div>

                        <div class="progress-step-item">
                            <div class="step-number">4</div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 2px;">Finalize Setup</div>
                                <div style="font-size: 13px; opacity: 0.85;">Customize your preferences</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Section --}}
            <div class="auth-form-section">
                <div class="form-card">
                    {{-- Header --}}
                    <div style="text-align: center; margin-bottom: 32px;">
                        <h1 class="auth-title">Create Your Business Account</h1>
                        <p class="auth-subtitle">Let's start with your business information</p>
                    </div>

                    {{-- Progress --}}
                    @include('auth.register.progress', ['currentStep' => 1])

                    {{-- Alerts --}}
                    @if ($errors->any())
                        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 14px 16px; margin-bottom: 20px;">
                            <div style="display: flex; align-items-start; gap: 10px;">
                                <i class="bi bi-circle-fill"></i>
                                <div style="flex: 1;">
                                    <strong style="color: #991b1b; font-size: 14px;">Please fix the following errors:</strong>
                                    <ul style="margin: 8px 0 0 0; padding-left: 20px; color: #991b1b; font-size: 13px;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('register.step1.post') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="business_name" class="form-label">Business Name <span style="color: #ec3737;">*</span></label>
                            <input type="text" class="form-input" id="business_name" name="business_name" value="{{ old('business_name', session('registration.step1.business_name')) }}" placeholder="Enter your business name" required autofocus>
                        </div>

                        {{-- Two Column Layout --}}
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div class="form-group">
                                <label for="business_type" class="form-label">Business Type <span style="color: #ec3737;">*</span></label>
                                <select class="form-select" id="business_type" name="business_type" required>
                                    <option value="">Select Business Type</option>
                                    <option value="retail_store" {{ old('business_type', session('registration.step1.business_type')) == 'retail_store' ? 'selected' : '' }}>Retail Store</option>
                                    <option value="wholesale" {{ old('business_type', session('registration.step1.business_type')) == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                                    <option value="restaurant" {{ old('business_type', session('registration.step1.business_type')) == 'restaurant' ? 'selected' : '' }}>Restaurant / Food Service</option>
                                    <option value="service" {{ old('business_type', session('registration.step1.business_type')) == 'service' ? 'selected' : '' }}>Service Business</option>
                                    <option value="manufacturing" {{ old('business_type', session('registration.step1.business_type')) == 'manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                    <option value="ecommerce" {{ old('business_type', session('registration.step1.business_type')) == 'ecommerce' ? 'selected' : '' }}>E-commerce</option>
                                    <option value="other" {{ old('business_type', session('registration.step1.business_type')) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="industry" class="form-label">Industry <span style="color: #ec3737;">*</span></label>
                                <select class="form-select" id="industry" name="industry" required>
                                    <option value="">Select Industry</option>
                                    <option value="electronics" {{ old('industry', session('registration.step1.industry')) == 'electronics' ? 'selected' : '' }}>Electronics</option>
                                    <option value="fashion_apparel" {{ old('industry', session('registration.step1.industry')) == 'fashion_apparel' ? 'selected' : '' }}>Fashion & Apparel</option>
                                    <option value="food_beverage" {{ old('industry', session('registration.step1.industry')) == 'food_beverage' ? 'selected' : '' }}>Food & Beverage</option>
                                    <option value="health_beauty" {{ old('industry', session('registration.step1.industry')) == 'health_beauty' ? 'selected' : '' }}>Health & Beauty</option>
                                    <option value="home_garden" {{ old('industry', session('registration.step1.industry')) == 'home_garden' ? 'selected' : '' }}>Home & Garden</option>
                                    <option value="automotive" {{ old('industry', session('registration.step1.industry')) == 'automotive' ? 'selected' : '' }}>Automotive</option>
                                    <option value="construction" {{ old('industry', session('registration.step1.industry')) == 'construction' ? 'selected' : '' }}>Construction</option>
                                    <option value="technology" {{ old('industry', session('registration.step1.industry')) == 'technology' ? 'selected' : '' }}>Technology</option>
                                    <option value="education" {{ old('industry', session('registration.step1.industry')) == 'education' ? 'selected' : '' }}>Education</option>
                                    <option value="healthcare" {{ old('industry', session('registration.step1.industry')) == 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                                    <option value="professional_services" {{ old('industry', session('registration.step1.industry')) == 'professional_services' ? 'selected' : '' }}>Professional Services</option>
                                    <option value="other" {{ old('industry', session('registration.step1.industry')) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div class="form-group">
                                <label for="business_phone" class="form-label">Business Phone <span style="color: #ec3737;">*</span></label>
                                <input type="tel" class="form-input" id="business_phone" name="business_phone" value="{{ old('business_phone', session('registration.step1.business_phone')) }}" placeholder="e.g., +63 912 345 6789" required>
                            </div>

                            <div class="form-group">
                                <label for="business_email" class="form-label">Business Email <span style="color: #ec3737;">*</span></label>
                                <input type="email" class="form-input" id="business_email" name="business_email" value="{{ old('business_email', session('registration.step1.business_email')) }}" placeholder="e.g., info@yourbusiness.com" required>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div class="form-group">
                                <label for="employees" class="form-label">Employees <span style="color: #ec3737;">*</span></label>
                                <select class="form-select" id="employees" name="employees" required>
                                    <option value="">Select</option>
                                    <option value="1-5" {{ old('employees', session('registration.step1.employees')) == '1-5' ? 'selected' : '' }}>1-5 employees</option>
                                    <option value="6-10" {{ old('employees', session('registration.step1.employees')) == '6-10' ? 'selected' : '' }}>6-10 employees</option>
                                    <option value="11-20" {{ old('employees', session('registration.step1.employees')) == '11-20' ? 'selected' : '' }}>11-20 employees</option>
                                    <option value="21-50" {{ old('employees', session('registration.step1.employees')) == '21-50' ? 'selected' : '' }}>21-50 employees</option>
                                    <option value="51-100" {{ old('employees', session('registration.step1.employees')) == '51-100' ? 'selected' : '' }}>51-100 employees</option>
                                    <option value="100+" {{ old('employees', session('registration.step1.employees')) == '100+' ? 'selected' : '' }}>100+ employees</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="years_in_business" class="form-label">Years in Business <span style="color: #ec3737;">*</span></label>
                                <select class="form-select" id="years_in_business" name="years_in_business" required>
                                    <option value="">Select</option>
                                    <option value="new" {{ old('years_in_business', session('registration.step1.years_in_business')) == 'new' ? 'selected' : '' }}>Just Starting</option>
                                    <option value="0-1" {{ old('years_in_business', session('registration.step1.years_in_business')) == '0-1' ? 'selected' : '' }}>Less than 1 year</option>
                                    <option value="1-3" {{ old('years_in_business', session('registration.step1.years_in_business')) == '1-3' ? 'selected' : '' }}>1-3 years</option>
                                    <option value="3-5" {{ old('years_in_business', session('registration.step1.years_in_business')) == '3-5' ? 'selected' : '' }}>3-5 years</option>
                                    <option value="5-10" {{ old('years_in_business', session('registration.step1.years_in_business')) == '5-10' ? 'selected' : '' }}>5-10 years</option>
                                    <option value="10+" {{ old('years_in_business', session('registration.step1.years_in_business')) == '10+' ? 'selected' : '' }}>10+ years</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary" style="margin-top: 24px;">
                            Continue to Next Step
                        </button>

                        <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #6c757d;">
                            Already have an account? <a href="{{ route('login') }}" style="color: #ec3737; text-decoration: none; font-weight: 600;">Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
