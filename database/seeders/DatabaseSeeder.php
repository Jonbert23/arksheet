<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Seeding ArkSheets Demo Data...');
        $this->command->info('');
        
        $this->call([
            BusinessSeeder::class,
            DefaultProductCategoriesSeeder::class,
            ExpenseCategorySeeder::class,
            DefaultBusinessSettingsSeeder::class,
            SalesChannelSeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
            ExpenseSeeder::class,
            SalesSeeder::class,
        ]);
        
        $this->command->info('');
        $this->command->info('✅ Demo data seeding completed!');
        $this->command->info('');
        $this->command->info('📧 Login Credentials:');
        $this->command->info('   Admin: admin@craphify.com / password');
        $this->command->info('   Manager: manager@craphify.com / password');
        $this->command->info('   Staff: staff@craphify.com / password');
    }
}
