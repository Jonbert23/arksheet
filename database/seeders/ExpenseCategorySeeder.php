<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
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

        // Default Expense Categories
        $defaultCategories = [
            [
                'name' => 'Office Supplies',
                'description' => 'Office equipment, stationery, and supplies',
                'is_active' => true,
            ],
            [
                'name' => 'Utilities',
                'description' => 'Electricity, water, internet, and other utilities',
                'is_active' => true,
            ],
            [
                'name' => 'Rent & Lease',
                'description' => 'Office or store rent and lease payments',
                'is_active' => true,
            ],
            [
                'name' => 'Salaries & Wages',
                'description' => 'Employee salaries and wages',
                'is_active' => true,
            ],
            [
                'name' => 'Marketing & Advertising',
                'description' => 'Marketing campaigns and advertising expenses',
                'is_active' => true,
            ],
            [
                'name' => 'Travel & Transport',
                'description' => 'Business travel and transportation costs',
                'is_active' => true,
            ],
            [
                'name' => 'Maintenance & Repairs',
                'description' => 'Equipment maintenance and repair costs',
                'is_active' => true,
            ],
            [
                'name' => 'Insurance',
                'description' => 'Business insurance premiums',
                'is_active' => true,
            ],
            [
                'name' => 'Professional Services',
                'description' => 'Legal, accounting, and consulting fees',
                'is_active' => true,
            ],
            [
                'name' => 'Training & Development',
                'description' => 'Employee training and development programs',
                'is_active' => true,
            ],
            [
                'name' => 'Bank Charges & Fees',
                'description' => 'Banking fees and transaction charges',
                'is_active' => true,
            ],
            [
                'name' => 'Miscellaneous',
                'description' => 'Other business expenses',
                'is_active' => true,
            ],
        ];

        foreach ($businesses as $business) {
            $this->command->info("Seeding default expense categories for: {$business->name}");

            // Seed Expense Categories
            foreach ($defaultCategories as $category) {
                ExpenseCategory::firstOrCreate(
                    [
                        'business_id' => $business->id,
                        'name' => $category['name'],
                    ],
                    [
                        'description' => $category['description'],
                        'is_active' => $category['is_active'],
                    ]
                );
            }

            $this->command->info("  ✓ Created " . count($defaultCategories) . " expense categories");
        }

        $this->command->info("\n✅ Default expense categories seeded successfully!");
    }
}
