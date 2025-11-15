<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Business;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $business = Business::first();
        
        if (!$business) {
            $this->command->warn('⚠️  No business found. Please run BusinessSeeder first.');
            return;
        }

        $this->command->info('💰 Seeding expense data...');

        // Create expense categories matching the screenshot
        $categories = [
            ['name' => 'General and Administration', 'description' => 'Administrative and general office expenses'],
            ['name' => 'Operational Expenses', 'description' => 'Day-to-day operational costs'],
            ['name' => 'Marketing & Advertisement', 'description' => 'Marketing and advertising expenses'],
            ['name' => 'Cost of Goods', 'description' => 'Inventory and product costs'],
            ['name' => 'Employee Payroll', 'description' => 'Employee salaries and wages'],
            ['name' => 'Professional Services', 'description' => 'Legal, accounting, consulting services'],
            ['name' => 'Technology & Software', 'description' => 'Software, hardware, and IT services'],
            ['name' => 'Research & Development', 'description' => 'R&D and innovation investments'],
            ['name' => 'Miscellaneous', 'description' => 'Other miscellaneous expenses'],
        ];

        $expenseCategories = [];
        foreach ($categories as $category) {
            $expenseCategories[] = ExpenseCategory::create([
                'business_id' => $business->id,
                'name' => $category['name'],
                'description' => $category['description'],
            ]);
        }

        $this->command->info('✅ Created ' . count($expenseCategories) . ' expense categories');

        // Create a map of category names to objects for easy lookup
        $categoryMap = [];
        foreach ($expenseCategories as $cat) {
            $categoryMap[$cat->name] = $cat;
        }

        // Specific expenses from the screenshot (using current year dates)
        $specificExpenses = [
            [
                'date' => '2025-01-01',
                'category' => 'General and Administration',
                'title' => 'Office Space for a Year',
                'amount' => 56000.00,
                'receipt' => '62384000',
                'vendor' => 'Sequoia Inc',
                'payment_method' => 'bank_transfer',
                'status' => 'fulfilled'
            ],
            [
                'date' => '2025-02-01',
                'category' => 'Operational Expenses',
                'title' => 'Facility for Production',
                'amount' => 76000.00,
                'receipt' => '62362000',
                'vendor' => 'Smith Manufacturing',
                'payment_method' => 'cash',
                'status' => 'unfulfilled'
            ],
            [
                'date' => '2025-03-01',
                'category' => 'Marketing & Advertisement',
                'title' => 'Posters for Branding',
                'amount' => 98000.00,
                'payment_method' => 'card',
                'status' => 'fulfilled'
            ],
            [
                'date' => '2025-04-01',
                'category' => 'Cost of Goods',
                'title' => 'Supplies',
                'amount' => 112000.00,
                'payment_method' => 'bank_transfer',
                'status' => 'fulfilled'
            ],
            [
                'date' => '2025-05-01',
                'category' => 'Employee Payroll',
                'title' => 'Payroll',
                'amount' => 131000.00,
                'payment_method' => 'bank_transfer',
                'status' => 'unfulfilled'
            ],
            [
                'date' => '2025-06-01',
                'category' => 'Professional Services',
                'title' => 'Professional Consultation',
                'amount' => 142250.00,
                'payment_method' => 'bank_transfer',
                'status' => 'unfulfilled'
            ],
            [
                'date' => '2025-07-01',
                'category' => 'Technology & Software',
                'title' => 'Subscriptions',
                'amount' => 153000.00,
                'payment_method' => 'card',
                'status' => 'fulfilled'
            ],
            [
                'date' => '2025-08-01',
                'category' => 'Research & Development',
                'title' => 'Investments',
                'amount' => 176000.00,
                'payment_method' => 'bank_transfer',
                'status' => 'fulfilled'
            ],
            [
                'date' => '2025-09-01',
                'category' => 'Miscellaneous',
                'title' => 'Utilities in the Facility',
                'amount' => 198000.00,
                'payment_method' => 'online',
                'status' => 'unfulfilled'
            ],
            [
                'date' => '2025-10-01',
                'category' => 'General and Administration',
                'title' => 'Lease Space',
                'amount' => 5000.00,
                'payment_method' => 'cash',
                'status' => 'fulfilled'
            ],
            [
                'date' => '2025-11-01',
                'category' => 'Operational Expenses',
                'title' => 'Equipment',
                'amount' => 8000.00,
                'payment_method' => 'card',
                'status' => 'fulfilled'
            ],
            [
                'date' => '2025-11-05',
                'category' => 'Marketing & Advertisement',
                'title' => 'Marketing',
                'amount' => 6800.00,
                'payment_method' => 'bank_transfer',
                'status' => 'fulfilled'
            ],
        ];

        // Create the specific expenses
        $expenseCount = 0;
        foreach ($specificExpenses as $expenseData) {
            $category = $categoryMap[$expenseData['category']] ?? null;
            
            if ($category) {
                Expense::create([
                    'business_id' => $business->id,
                    'category_id' => $category->id,
                    'title' => $expenseData['title'],
                    'amount' => $expenseData['amount'],
                    'date' => $expenseData['date'],
                    'receipt' => $expenseData['receipt'] ?? null,
                    'vendor' => $expenseData['vendor'] ?? null,
                    'payment_method' => $expenseData['payment_method'] ?? null,
                    'status' => $expenseData['status'] ?? 'unfulfilled',
                    'notes' => $expenseData['notes'] ?? null,
                    'description' => null,
                ]);
                
                $expenseCount++;
            }
        }

        $this->command->info("✅ Created {$expenseCount} specific expenses from screenshot data");
    }
}

