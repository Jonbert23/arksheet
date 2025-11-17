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

        // Default Payment Methods
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
                'setting_value' => 'bank_transfer',
                'setting_label' => 'Bank Transfer',
                'description' => 'Direct bank transfer',
                'sort_order' => 2,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'credit_card',
                'setting_label' => 'Credit Card',
                'description' => 'Credit card payment',
                'sort_order' => 3,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'debit_card',
                'setting_label' => 'Debit Card',
                'description' => 'Debit card payment',
                'sort_order' => 4,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'mobile_money',
                'setting_label' => 'Mobile Money',
                'description' => 'Mobile wallet payment',
                'sort_order' => 5,
                'is_active' => true,
                'is_system' => false,
            ],
            [
                'setting_key' => 'payment_method',
                'setting_value' => 'check',
                'setting_label' => 'Check',
                'description' => 'Payment by check',
                'sort_order' => 6,
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

        foreach ($businesses as $business) {
            $this->command->info("Seeding default business settings for: {$business->name}");

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
        }

        $this->command->info("\n✅ Default business settings seeded successfully!");
    }
}

