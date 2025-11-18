<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * STEP 1: Business Information
     */
    public function showStep1()
    {
        return view('auth.register.step1');
    }

    public function postStep1(Request $request)
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'max:100'],
            'industry' => ['required', 'string', 'max:100'],
            'business_phone' => ['required', 'string', 'max:20'],
            'business_email' => ['required', 'email', 'max:255'],
            'employees' => ['required', 'string', 'max:50'],
            'years_in_business' => ['required', 'string', 'max:50'],
        ]);

        // Set default country and currency for Philippines
        $validated['country'] = 'Philippines';
        $validated['currency'] = 'PHP';

        session()->put('registration.step1', $validated);
        return redirect()->route('register.step2');
    }

    /**
     * STEP 2: Owner Account
     */
    public function showStep2()
    {
        if (!session()->has('registration.step1')) {
            return redirect()->route('register');
        }
        return view('auth.register.step2');
    }

    public function postStep2(Request $request)
    {
        if (!session()->has('registration.step1')) {
            return redirect()->route('register');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        session()->put('registration.step2', $validated);
        return redirect()->route('register.step3');
    }

    /**
     * STEP 3: Business Location
     */
    public function showStep3()
    {
        if (!session()->has('registration.step1') || !session()->has('registration.step2')) {
            return redirect()->route('register');
        }
        return view('auth.register.step3');
    }

    public function postStep3(Request $request)
    {
        if (!session()->has('registration.step1') || !session()->has('registration.step2')) {
            return redirect()->route('register');
        }

        $validated = $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'timezone' => ['required', 'string', 'max:100'],
            'tax_id' => ['nullable', 'string', 'max:100'],
        ]);

        session()->put('registration.step3', $validated);
        return redirect()->route('register.step4');
    }

    /**
     * STEP 4: Finalize Setup
     */
    public function showStep4()
    {
        if (!session()->has('registration.step1') || 
            !session()->has('registration.step2') || 
            !session()->has('registration.step3')) {
            return redirect()->route('register');
        }
        return view('auth.register.step4');
    }

    /**
     * Complete Registration
     */
    public function complete(Request $request)
    {
        if (!session()->has('registration.step1') || 
            !session()->has('registration.step2') || 
            !session()->has('registration.step3')) {
            return redirect()->route('register');
        }

        $validated = $request->validate([
            'logo' => ['nullable', 'image', 'max:2048'],
            'business_hours' => ['nullable', 'string', 'max:255'],
            'payment_methods' => ['nullable', 'array'],
            'payment_methods.*' => ['string', 'max:50'],
            'product_categories' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            DB::beginTransaction();

            // Get all step data
            $step1 = session('registration.step1');
            $step2 = session('registration.step2');
            $step3 = session('registration.step3');

            // Handle logo upload
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }

            // Create Business
            $business = Business::create([
                'name' => $step1['business_name'],
                'category' => $step1['industry'],
                'founder' => $step2['name'],
                'date_founded' => now(),
                'is_active' => true,
                'logo' => $logoPath,
                'address' => $step3['address'],
                'city' => $step3['city'],
                'state' => $step3['state'],
                'postal_code' => $step3['postal_code'],
                'country' => $step1['country'], // Philippines
                'currency' => $step1['currency'], // PHP
                'timezone' => $step3['timezone'],
                'tax_id' => $step3['tax_id'],
                'business_type' => $step1['business_type'],
                'business_hours' => $validated['business_hours'] ?? null,
                'phone' => $step1['business_phone'],
                'email' => $step1['business_email'],
                'employees' => $step1['employees'],
                'years_in_business' => $step1['years_in_business'],
            ]);

            // Create Admin User
            $user = User::create([
                'business_id' => $business->id,
                'name' => $step2['name'],
                'email' => $step2['email'],
                'password' => Hash::make($step2['password']),
                'phone' => $step2['phone'],
                'role' => 'admin',
                'is_active' => true,
            ]);

            // Store payment methods if provided
            if (!empty($validated['payment_methods'])) {
                foreach ($validated['payment_methods'] as $index => $method) {
                    \App\Models\BusinessSetting::create([
                        'business_id' => $business->id,
                        'setting_key' => 'payment_method',
                        'setting_value' => $method,
                        'setting_label' => $method,
                        'sort_order' => $index,
                        'is_active' => true,
                    ]);
                }
            }

            // Store product categories if provided
            if (!empty($validated['product_categories'])) {
                $categories = array_filter(array_map('trim', explode(',', $validated['product_categories'])));
                foreach ($categories as $index => $category) {
                    \App\Models\ProductCategory::create([
                        'business_id' => $business->id,
                        'name' => $category,
                        'display_order' => $index,
                        'is_active' => true,
                    ]);
                }
            }

            DB::commit();

            // Clear registration session data
            session()->forget('registration');

            // Auto login
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Welcome to ArkSheets! Your business account has been created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Registration failed. Please try again. Error: ' . $e->getMessage());
        }
    }
}
