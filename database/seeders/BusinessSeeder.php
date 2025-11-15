<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
use App\Models\Customer;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Demo Business
        $business = Business::create([
            'name' => 'Craphify',
            'slug' => 'craphify',
            'founder' => 'Jonbert Andam',
            'category' => 'Software',
            'date_founded' => '2025-01-01',
            'email' => 'info@craphify.com',
            'phone' => '+63 912 345 6789',
            'address' => 'Manila, Philippines',
            'currency' => 'PHP',
            'timezone' => 'Asia/Manila',
            'is_active' => true,
        ]);

        // Create Admin User
        User::create([
            'business_id' => $business->id,
            'name' => 'Admin User',
            'email' => 'admin@craphify.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+63 912 345 6790',
            'is_active' => true,
        ]);

        // Create Manager User
        User::create([
            'business_id' => $business->id,
            'name' => 'John Manager',
            'email' => 'manager@craphify.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '+63 912 345 6791',
            'is_active' => true,
        ]);

        // Create Staff User
        User::create([
            'business_id' => $business->id,
            'name' => 'Jane Staff',
            'email' => 'staff@craphify.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '+63 912 345 6792',
            'is_active' => true,
        ]);

        // Create Sample Customers
        $customers = [
            ['name' => 'ABC Corporation', 'email' => 'contact@abc.com', 'phone' => '+63 917 123 4567', 'company' => 'ABC Corp'],
            ['name' => 'XYZ Enterprises', 'email' => 'info@xyz.com', 'phone' => '+63 918 234 5678', 'company' => 'XYZ Ltd'],
            ['name' => 'Tech Solutions Inc', 'email' => 'hello@techsol.com', 'phone' => '+63 919 345 6789', 'company' => 'Tech Solutions'],
            ['name' => 'Global Trading Co', 'email' => 'sales@globaltrading.com', 'phone' => '+63 920 456 7890', 'company' => 'Global Trading'],
            ['name' => 'Innovation Hub', 'email' => 'contact@innohub.com', 'phone' => '+63 921 567 8901', 'company' => 'Innovation Hub'],
        ];

        foreach ($customers as $customer) {
            Customer::create(array_merge($customer, [
                'business_id' => $business->id,
                'is_active' => true,
            ]));
        }

        // Create Expense Categories
        $expenseCategories = [
            ['name' => 'General and Administration', 'description' => 'Office supplies, utilities, etc.'],
            ['name' => 'Operational Expenses', 'description' => 'Day-to-day operational costs'],
            ['name' => 'Marketing & Advertisement', 'description' => 'Marketing and advertising expenses'],
            ['name' => 'Cost of Goods', 'description' => 'Direct costs of products sold'],
            ['name' => 'Employee Payroll', 'description' => 'Salaries and benefits'],
            ['name' => 'Rent & Utilities', 'description' => 'Office rent and utilities'],
            ['name' => 'Technology & Software', 'description' => 'Software licenses and tech expenses'],
        ];

        foreach ($expenseCategories as $category) {
            ExpenseCategory::create(array_merge($category, [
                'business_id' => $business->id,
                'is_active' => true,
            ]));
        }

        $this->command->info('✓ Demo Business "Craphify" created!');
        $this->command->info('✓ Users created (admin@craphify.com / manager@craphify.com / staff@craphify.com)');
        $this->command->info('✓ Password for all users: password');
    }
}
