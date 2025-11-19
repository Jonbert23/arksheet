<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Business Account - Step 3 | ArkSheets</title>
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
                        Step 3 of 4
                    </div>
                    
                    <h2 class="announcement-title">Almost There!</h2>
                    <p class="announcement-subtitle">Help us set up your business location and timezone to ensure accurate records and reporting.</p>

                    <div style="margin-top: 32px;">
                        <div class="progress-step-item" style="opacity: 0.6;">
                            <div class="step-number">✓</div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 2px;">Business Information</div>
                                <div style="font-size: 13px; opacity: 0.85;">Completed</div>
                            </div>
                        </div>

                        <div class="progress-step-item" style="opacity: 0.6;">
                            <div class="step-number">✓</div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 2px;">Owner Account</div>
                                <div style="font-size: 13px; opacity: 0.85;">Completed</div>
                            </div>
                        </div>

                        <div class="progress-step-item active">
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
                        <h1 class="auth-title">Business Location</h1>
                        <p class="auth-subtitle">Tell us where your business is located</p>
                    </div>

                    {{-- Progress --}}
                    @include('auth.register.progress', ['currentStep' => 3])

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
                    <form action="{{ route('register.step3.post') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="address" class="form-label">Street Address <span style="color: #ec3737;">*</span></label>
                            <input type="text" class="form-input" id="address" name="address" value="{{ old('address', session('registration.step3.address')) }}" placeholder="Enter your business address" required autofocus>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div class="form-group">
                                <label for="city" class="form-label">City <span style="color: #ec3737;">*</span></label>
                                <input type="text" class="form-input" id="city" name="city" value="{{ old('city', session('registration.step3.city')) }}" placeholder="Enter city" required>
                            </div>

                            <div class="form-group">
                                <label for="state" class="form-label">State/Province <span style="color: #ec3737;">*</span></label>
                                <input type="text" class="form-input" id="state" name="state" value="{{ old('state', session('registration.step3.state')) }}" placeholder="Enter state/province" required>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div class="form-group">
                                <label for="postal_code" class="form-label">Postal Code <span style="color: #ec3737;">*</span></label>
                                <input type="text" class="form-input" id="postal_code" name="postal_code" value="{{ old('postal_code', session('registration.step3.postal_code')) }}" placeholder="Enter postal code" required>
                            </div>

                            <div class="form-group">
                                <label for="timezone" class="form-label">Time Zone <span style="color: #ec3737;">*</span></label>
                                <select class="form-select" id="timezone" name="timezone" required>
                                    <option value="">Select Time Zone</option>
                                    <option value="Asia/Manila" {{ old('timezone', session('registration.step3.timezone')) == 'Asia/Manila' ? 'selected' : '' }}>Asia/Manila (PHT)</option>
                                    <option value="America/New_York" {{ old('timezone', session('registration.step3.timezone')) == 'America/New_York' ? 'selected' : '' }}>America/New York (EST)</option>
                                    <option value="America/Chicago" {{ old('timezone', session('registration.step3.timezone')) == 'America/Chicago' ? 'selected' : '' }}>America/Chicago (CST)</option>
                                    <option value="America/Los_Angeles" {{ old('timezone', session('registration.step3.timezone')) == 'America/Los_Angeles' ? 'selected' : '' }}>America/Los Angeles (PST)</option>
                                    <option value="Europe/London" {{ old('timezone', session('registration.step3.timezone')) == 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>
                                    <option value="Europe/Paris" {{ old('timezone', session('registration.step3.timezone')) == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris (CET)</option>
                                    <option value="Asia/Tokyo" {{ old('timezone', session('registration.step3.timezone')) == 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo (JST)</option>
                                    <option value="Asia/Shanghai" {{ old('timezone', session('registration.step3.timezone')) == 'Asia/Shanghai' ? 'selected' : '' }}>Asia/Shanghai (CST)</option>
                                    <option value="Asia/Singapore" {{ old('timezone', session('registration.step3.timezone')) == 'Asia/Singapore' ? 'selected' : '' }}>Asia/Singapore (SGT)</option>
                                    <option value="Australia/Sydney" {{ old('timezone', session('registration.step3.timezone')) == 'Australia/Sydney' ? 'selected' : '' }}>Australia/Sydney (AEDT)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tax_id" class="form-label">Tax ID / Business Registration</label>
                            <input type="text" class="form-input" id="tax_id" name="tax_id" value="{{ old('tax_id', session('registration.step3.tax_id')) }}" placeholder="Enter tax ID (optional)">
                            <small style="color: #6b7280; font-size: 13px; display: block; margin-top: 6px;">Required for invoicing and tax purposes</small>
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
