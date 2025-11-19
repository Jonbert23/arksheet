<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use App\Models\BusinessSetting;
use App\Models\ProductCategory;
use App\Models\ExpenseCategory;
use App\Models\SalesChannel;
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

            // Create Business Owner User
            $user = User::create([
                'business_id' => $business->id,
                'name' => $step2['name'],
                'email' => $step2['email'],
                'password' => Hash::make($step2['password']),
                'phone' => $step2['phone'],
                'role' => 'business_owner',
                'is_active' => true,
            ]);

            // Seed default business data FIRST
            $this->seedDefaultBusinessData($business);

            // Then add any custom payment methods from registration form (if provided)
            if (!empty($validated['payment_methods'])) {
                foreach ($validated['payment_methods'] as $index => $method) {
                    BusinessSetting::firstOrCreate(
                        [
                            'business_id' => $business->id,
                            'setting_key' => 'payment_method',
                            'setting_value' => strtolower(str_replace(' ', '_', $method)),
                        ],
                        [
                            'setting_label' => $method,
                            'sort_order' => 100 + $index, // High sort order to appear after defaults
                            'is_active' => true,
                            'is_system' => false,
                        ]
                    );
                }
            }

            // Add any custom product categories from registration form (if provided)
            if (!empty($validated['product_categories'])) {
                $categories = array_filter(array_map('trim', explode(',', $validated['product_categories'])));
                foreach ($categories as $index => $category) {
                    ProductCategory::firstOrCreate(
                        [
                            'business_id' => $business->id,
                            'name' => $category,
                        ],
                        [
                            'description' => null,
                            'is_active' => true,
                        ]
                    );
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

    /**
     * Seed default business data for a new business
     */
    private function seedDefaultBusinessData(Business $business)
    {
        // Default Product Types
        $productTypes = [
            ['value' => 'product', 'label' => 'Physical Product', 'description' => 'Tangible goods that can be shipped', 'order' => 1, 'system' => true],
            ['value' => 'digital', 'label' => 'Digital Product', 'description' => 'Downloadable or online products', 'order' => 2, 'system' => false],
            ['value' => 'service', 'label' => 'Service', 'description' => 'Intangible services provided to customers', 'order' => 3, 'system' => true],
            ['value' => 'subscription', 'label' => 'Subscription', 'description' => 'Recurring subscription-based products', 'order' => 4, 'system' => false],
        ];

        foreach ($productTypes as $type) {
            BusinessSetting::firstOrCreate(
                [
                    'business_id' => $business->id,
                    'setting_key' => 'product_type',
                    'setting_value' => $type['value'],
                ],
                [
                    'setting_label' => $type['label'],
                    'description' => $type['description'],
                    'sort_order' => $type['order'],
                    'is_active' => true,
                    'is_system' => $type['system'],
                ]
            );
        }

        // Default Units of Measurement
        $units = [
            ['value' => 'pcs', 'label' => 'Pieces', 'description' => 'Individual items or units', 'order' => 1, 'system' => true],
            ['value' => 'kg', 'label' => 'Kilogram', 'description' => 'Weight measurement in kilograms', 'order' => 2, 'system' => true],
            ['value' => 'lbs', 'label' => 'Pounds', 'description' => 'Weight measurement in pounds', 'order' => 3, 'system' => false],
            ['value' => 'ltr', 'label' => 'Liter', 'description' => 'Volume measurement in liters', 'order' => 4, 'system' => false],
            ['value' => 'gal', 'label' => 'Gallon', 'description' => 'Volume measurement in gallons', 'order' => 5, 'system' => false],
            ['value' => 'm', 'label' => 'Meter', 'description' => 'Length measurement in meters', 'order' => 6, 'system' => false],
            ['value' => 'box', 'label' => 'Box', 'description' => 'Items sold in boxes', 'order' => 7, 'system' => false],
            ['value' => 'pack', 'label' => 'Pack', 'description' => 'Items sold in packs', 'order' => 8, 'system' => false],
        ];

        foreach ($units as $unit) {
            BusinessSetting::firstOrCreate(
                [
                    'business_id' => $business->id,
                    'setting_key' => 'unit_of_measurement',
                    'setting_value' => $unit['value'],
                ],
                [
                    'setting_label' => $unit['label'],
                    'description' => $unit['description'],
                    'sort_order' => $unit['order'],
                    'is_active' => true,
                    'is_system' => $unit['system'],
                ]
            );
        }

        // Default Payment Methods (Philippines-specific)
        $paymentMethods = [
            ['value' => 'cash', 'label' => 'Cash', 'description' => 'Cash payment', 'order' => 1, 'system' => true],
            ['value' => 'gcash', 'label' => 'GCash', 'description' => 'GCash e-wallet payment', 'order' => 2, 'system' => false],
            ['value' => 'paymaya', 'label' => 'Maya (PayMaya)', 'description' => 'Maya (formerly PayMaya) e-wallet', 'order' => 3, 'system' => false],
            ['value' => 'bank_transfer', 'label' => 'Bank Transfer', 'description' => 'InstaPay, PESONet, or direct bank transfer', 'order' => 4, 'system' => false],
            ['value' => 'credit_card', 'label' => 'Credit Card', 'description' => 'Visa, Mastercard, JCB', 'order' => 5, 'system' => false],
            ['value' => 'debit_card', 'label' => 'Debit Card', 'description' => 'ATM/Debit card payment', 'order' => 6, 'system' => false],
            ['value' => 'shopeepay', 'label' => 'ShopeePay', 'description' => 'ShopeePay e-wallet', 'order' => 7, 'system' => false],
            ['value' => 'grabpay', 'label' => 'GrabPay', 'description' => 'GrabPay e-wallet', 'order' => 8, 'system' => false],
            ['value' => 'coins_ph', 'label' => 'Coins.ph', 'description' => 'Coins.ph wallet', 'order' => 9, 'system' => false],
            ['value' => 'check', 'label' => 'Check', 'description' => 'Payment by check', 'order' => 10, 'system' => false],
            ['value' => 'cod', 'label' => 'Cash on Delivery (COD)', 'description' => 'Payment upon delivery', 'order' => 11, 'system' => false],
            ['value' => 'bayad_center', 'label' => 'Bayad Center', 'description' => 'Payment via Bayad Center', 'order' => 12, 'system' => false],
            ['value' => '711_cliqq', 'label' => '7-Eleven CLiQQ', 'description' => 'Payment via 7-Eleven CLiQQ', 'order' => 13, 'system' => false],
        ];

        foreach ($paymentMethods as $method) {
            BusinessSetting::firstOrCreate(
                [
                    'business_id' => $business->id,
                    'setting_key' => 'payment_method',
                    'setting_value' => $method['value'],
                ],
                [
                    'setting_label' => $method['label'],
                    'description' => $method['description'],
                    'sort_order' => $method['order'],
                    'is_active' => true,
                    'is_system' => $method['system'],
                ]
            );
        }

        // Default Payment Statuses
        $paymentStatuses = [
            ['value' => 'paid', 'label' => 'Paid', 'description' => 'Payment completed', 'order' => 1, 'system' => true],
            ['value' => 'pending', 'label' => 'Pending', 'description' => 'Payment pending', 'order' => 2, 'system' => true],
            ['value' => 'partial', 'label' => 'Partial', 'description' => 'Partially paid', 'order' => 3, 'system' => false],
            ['value' => 'overdue', 'label' => 'Overdue', 'description' => 'Payment overdue', 'order' => 4, 'system' => false],
            ['value' => 'cancelled', 'label' => 'Cancelled', 'description' => 'Payment cancelled', 'order' => 5, 'system' => false],
        ];

        foreach ($paymentStatuses as $status) {
            BusinessSetting::firstOrCreate(
                [
                    'business_id' => $business->id,
                    'setting_key' => 'payment_status',
                    'setting_value' => $status['value'],
                ],
                [
                    'setting_label' => $status['label'],
                    'description' => $status['description'],
                    'sort_order' => $status['order'],
                    'is_active' => true,
                    'is_system' => $status['system'],
                ]
            );
        }

        // Default Expense Statuses
        $expenseStatuses = [
            ['value' => 'approved', 'label' => 'Approved', 'description' => 'Expense has been approved', 'order' => 1, 'system' => true],
            ['value' => 'pending', 'label' => 'Pending', 'description' => 'Awaiting approval', 'order' => 2, 'system' => true],
            ['value' => 'rejected', 'label' => 'Rejected', 'description' => 'Expense has been rejected', 'order' => 3, 'system' => false],
            ['value' => 'reimbursed', 'label' => 'Reimbursed', 'description' => 'Expense has been reimbursed', 'order' => 4, 'system' => false],
        ];

        foreach ($expenseStatuses as $status) {
            BusinessSetting::firstOrCreate(
                [
                    'business_id' => $business->id,
                    'setting_key' => 'expense_status',
                    'setting_value' => $status['value'],
                ],
                [
                    'setting_label' => $status['label'],
                    'description' => $status['description'],
                    'sort_order' => $status['order'],
                    'is_active' => true,
                    'is_system' => $status['system'],
                ]
            );
        }

        // Default Product Categories
        $categories = [
            'Electronics', 'Clothing & Apparel', 'Food & Beverages', 'Home & Garden',
            'Health & Beauty', 'Sports & Outdoors', 'Books & Media', 'Toys & Games',
            'Office Supplies', 'Automotive'
        ];

        foreach ($categories as $index => $category) {
            ProductCategory::firstOrCreate(
                [
                    'business_id' => $business->id,
                    'name' => $category,
                ],
                [
                    'description' => null,
                    'is_active' => true,
                ]
            );
        }

        // Default Expense Categories
        $expenseCategories = [
            ['name' => 'Office Supplies', 'description' => 'Office equipment, stationery, and supplies'],
            ['name' => 'Utilities', 'description' => 'Electricity, water, internet, and other utilities'],
            ['name' => 'Rent & Lease', 'description' => 'Office or store rent and lease payments'],
            ['name' => 'Salaries & Wages', 'description' => 'Employee salaries and wages'],
            ['name' => 'Marketing & Advertising', 'description' => 'Marketing campaigns and advertising expenses'],
            ['name' => 'Travel & Transport', 'description' => 'Business travel and transportation costs'],
            ['name' => 'Maintenance & Repairs', 'description' => 'Equipment maintenance and repair costs'],
            ['name' => 'Insurance', 'description' => 'Business insurance premiums'],
            ['name' => 'Professional Services', 'description' => 'Legal, accounting, and consulting fees'],
            ['name' => 'Training & Development', 'description' => 'Employee training and development programs'],
            ['name' => 'Bank Charges & Fees', 'description' => 'Banking fees and transaction charges'],
            ['name' => 'Miscellaneous', 'description' => 'Other business expenses'],
        ];

        foreach ($expenseCategories as $category) {
            ExpenseCategory::firstOrCreate(
                [
                    'business_id' => $business->id,
                    'name' => $category['name'],
                ],
                [
                    'description' => $category['description'],
                    'is_active' => true,
                ]
            );
        }

        // Default Sales Channels
        $salesChannels = [
            ['name' => 'Physical Store', 'description' => 'Main retail store location'],
            ['name' => '2nd Branch', 'description' => 'Secondary store location'],
            ['name' => 'Online Store', 'description' => 'E-commerce website'],
            ['name' => 'Shopify', 'description' => 'Shopify marketplace'],
            ['name' => 'TikTok', 'description' => 'TikTok Shop'],
            ['name' => 'Facebook Marketplace', 'description' => 'Facebook marketplace sales'],
            ['name' => 'Instagram', 'description' => 'Instagram shop'],
        ];

        foreach ($salesChannels as $channel) {
            SalesChannel::firstOrCreate(
                [
                    'business_id' => $business->id,
                    'name' => $channel['name'],
                ],
                [
                    'description' => $channel['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
