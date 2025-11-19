<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessSetting;
use Illuminate\Database\Seeder;

class DefaultBusinessSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all businesses
        $businesses = Business::all();

        if ($businesses->isEmpty()) {
            $this->command->warn('No businesses found. Please create a business first.');
            return;
        }

        // Default Units of Measurement
        $defaultUnits = [
            [
                'setting_key' => 'unit_of_measurement',
                'setting_value' => 'pcs',
                'setting_label' => 'Pieces',
                'description' => 'Individual items or units',
                'sort_order' => 1,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'unit_of_measurement',
                'setting_value' => 'kg',
                'setting_label' => 'Kilogram',
                'description' => 'Weight measurement in kilograms',
                'sort_order' => 2,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'unit_of_measurement',
                'setting_value' => 'lbs',
                'setting_label' => 'Pounds',
                'description' => 'Weight measurement in pounds',
                'sort_order' => 3,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'unit_of_measurement',
                'setting_value' => 'ltr',
                'setting_label' => 'Liter',
                'description' => 'Volume measurement in liters',
                'sort_order' => 4,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'unit_of_measurement',
                'setting_value' => 'gal',
                'setting_label' => 'Gallon',
                'description' => 'Volume measurement in gallons',
                'sort_order' => 5,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'unit_of_measurement',
                'setting_value' => 'm',
                'setting_label' => 'Meter',
                'description' => 'Length measurement in meters',
                'sort_order' => 6,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'unit_of_measurement',
                'setting_value' => 'box',
                'setting_label' => 'Box',
                'description' => 'Items sold in boxes',
                'sort_order' => 7,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'unit_of_measurement',
                'setting_value' => 'pack',
                'setting_label' => 'Pack',
                'description' => 'Items sold in packs',
                'sort_order' => 8,
                'is_active' => true,
                'is_system' => false,
            ],
        ];

        // Default Payment Methods (Philippines-specific)
        $defaultPaymentMethods = [
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'cash',
                'setting_label' => 'Cash',
                'description' => 'Cash payment',
                'sort_order' => 1,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'gcash',
                'setting_label' => 'GCash',
                'description' => 'GCash e-wallet payment',
                'sort_order' => 2,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'paymaya',
                'setting_label' => 'Maya (PayMaya)',
                'description' => 'Maya (formerly PayMaya) e-wallet',
                'sort_order' => 3,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'bank_transfer',
                'setting_label' => 'Bank Transfer',
                'description' => 'InstaPay, PESONet, or direct bank transfer',
                'sort_order' => 4,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'credit_card',
                'setting_label' => 'Credit Card',
                'description' => 'Visa, Mastercard, JCB',
                'sort_order' => 5,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'debit_card',
                'setting_label' => 'Debit Card',
                'description' => 'ATM/Debit card payment',
                'sort_order' => 6,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'shopeepay',
                'setting_label' => 'ShopeePay',
                'description' => 'ShopeePay e-wallet',
                'sort_order' => 7,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'grabpay',
                'setting_label' => 'GrabPay',
                'description' => 'GrabPay e-wallet',
                'sort_order' => 8,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'coins_ph',
                'setting_label' => 'Coins.ph',
                'description' => 'Coins.ph wallet',
                'sort_order' => 9,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'check',
                'setting_label' => 'Check',
                'description' => 'Payment by check',
                'sort_order' => 10,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'cod',
                'setting_label' => 'Cash on Delivery (COD)',
                'description' => 'Payment upon delivery',
                'sort_order' => 11,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'bayad_center',
                'setting_label' => 'Bayad Center',
                'description' => 'Payment via Bayad Center',
                'sort_order' => 12,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => '711_cliqq',
                'setting_label' => '7-Eleven CLiQQ',
                'description' => 'Payment via 7-Eleven CLiQQ',
                'sort_order' => 13,
                'is_active' => true,
                'is_system' => false,
            ],
        ];

        // Default Payment Statuses
        $defaultPaymentStatuses = [
            [
                'setting_key' => 'payment_status',
                'setting_value' => 'paid',
                'setting_label' => 'Paid',
                'description' => 'Payment completed',
                'sort_order' => 1,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'payment_status',
                'setting_value' => 'pending',
                'setting_label' => 'Pending',
                'description' => 'Payment pending',
                'sort_order' => 2,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'payment_status',
                'setting_value' => 'partial',
                'setting_label' => 'Partial',
                'description' => 'Partially paid',
                'sort_order' => 3,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_status',
                'setting_value' => 'overdue',
                'setting_label' => 'Overdue',
                'description' => 'Payment overdue',
                'sort_order' => 4,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_status',
                'setting_value' => 'cancelled',
                'setting_label' => 'Cancelled',
                'description' => 'Payment cancelled',
                'sort_order' => 5,
                'is_active' => true,
                'is_system' => false,
            ],
        ];

        // Default Product Types
        $defaultProductTypes = [
            [
                'setting_key' => 'product_type',
                'setting_value' => 'product',
                'setting_label' => 'Physical Product',
                'description' => 'Tangible goods that can be shipped',
                'sort_order' => 1,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'product_type',
                'setting_value' => 'digital',
                'setting_label' => 'Digital Product',
                'description' => 'Downloadable or online products',
                'sort_order' => 2,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'product_type',
                'setting_value' => 'service',
                'setting_label' => 'Service',
                'description' => 'Intangible services provided to customers',
                'sort_order' => 3,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'product_type',
                'setting_value' => 'subscription',
                'setting_label' => 'Subscription',
                'description' => 'Recurring subscription-based products',
                'sort_order' => 4,
                'is_active' => true,
                'is_system' => false,
            ],
        ];

        // Default Expense Statuses
        $defaultExpenseStatuses = [
            [
                'setting_key' => 'expense_status',
                'setting_value' => 'approved',
                'setting_label' => 'Approved',
                'description' => 'Expense has been approved',
                'sort_order' => 1,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'expense_status',
                'setting_value' => 'pending',
                'setting_label' => 'Pending',
                'description' => 'Awaiting approval',
                'sort_order' => 2,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'expense_status',
                'setting_value' => 'rejected',
                'setting_label' => 'Rejected',
                'description' => 'Expense has been rejected',
                'sort_order' => 3,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'expense_status',
                'setting_value' => 'reimbursed',
                'setting_label' => 'Reimbursed',
                'description' => 'Expense has been reimbursed',
                'sort_order' => 4,
                'is_active' => true,
                'is_system' => false,
            ],
        ];

        foreach ($businesses as $business) {
            $this->command->info("Seeding default business settings for: {$business->name}");

            // Seed Product Types
            foreach ($defaultProductTypes as $type) {
                BusinessSetting::firstOrCreate(
                    [
                        'business_id' => $business->id,
                        'setting_key' => $type['setting_key'],
                        'setting_value' => $type['setting_value'],
                    ],
                    [
                        'setting_label' => $type['setting_label'],
                        'description' => $type['description'],
                        'sort_order' => $type['sort_order'],
                        'is_active' => $type['is_active'],
                        'is_system' => $type['is_system'],
                    ]
                );
            }
            $this->command->info("  ✓ Created " . count($defaultProductTypes) . " product types");

            // Seed Units
            foreach ($defaultUnits as $unit) {
                BusinessSetting::firstOrCreate(
                    [
                        'business_id' => $business->id,
                        'setting_key' => $unit['setting_key'],
                        'setting_value' => $unit['setting_value'],
                    ],
                    [
                        'setting_label' => $unit['setting_label'],
                        'description' => $unit['description'],
                        'sort_order' => $unit['sort_order'],
                        'is_active' => $unit['is_active'],
                        'is_system' => $unit['is_system'],
                    ]
                );
            }
            $this->command->info("  ✓ Created " . count($defaultUnits) . " units of measurement");

            // Seed Payment Methods
            foreach ($defaultPaymentMethods as $method) {
                BusinessSetting::firstOrCreate(
                    [
                        'business_id' => $business->id,
                        'setting_key' => $method['setting_key'],
                        'setting_value' => $method['setting_value'],
                    ],
                    [
                        'setting_label' => $method['setting_label'],
                        'description' => $method['description'],
                        'sort_order' => $method['sort_order'],
                        'is_active' => $method['is_active'],
                        'is_system' => $method['is_system'],
                    ]
                );
            }
            $this->command->info("  ✓ Created " . count($defaultPaymentMethods) . " payment methods");

            // Seed Payment Statuses
            foreach ($defaultPaymentStatuses as $status) {
                BusinessSetting::firstOrCreate(
                    [
                        'business_id' => $business->id,
                        'setting_key' => $status['setting_key'],
                        'setting_value' => $status['setting_value'],
                    ],
                    [
                        'setting_label' => $status['setting_label'],
                        'description' => $status['description'],
                        'sort_order' => $status['sort_order'],
                        'is_active' => $status['is_active'],
                        'is_system' => $status['is_system'],
                    ]
                );
            }
            $this->command->info("  ✓ Created " . count($defaultPaymentStatuses) . " payment statuses");

            // Seed Expense Statuses
            foreach ($defaultExpenseStatuses as $expenseStatus) {
                BusinessSetting::firstOrCreate(
                    [
                        'business_id' => $business->id,
                        'setting_key' => $expenseStatus['setting_key'],
                        'setting_value' => $expenseStatus['setting_value'],
                    ],
                    [
                        'setting_label' => $expenseStatus['setting_label'],
                        'description' => $expenseStatus['description'],
                        'sort_order' => $expenseStatus['sort_order'],
                        'is_active' => $expenseStatus['is_active'],
                        'is_system' => $expenseStatus['is_system'],
                    ]
                );
            }
            $this->command->info("  ✓ Created " . count($defaultExpenseStatuses) . " expense statuses");
        }

        $this->command->info("\n✅ Default business settings seeded successfully!");
    }
}

