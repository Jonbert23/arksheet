<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;
use Database\Seeders\DefaultProductCategoriesSeeder;
use Database\Seeders\DefaultBusinessSettingsSeeder;

class SeedBusinessDefaults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business:seed-defaults {--business_id= : Specific business ID to seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed default product categories and business settings for businesses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🌱 Seeding Default Business Configuration...');
        $this->newLine();

        // Check if specific business ID provided
        if ($businessId = $this->option('business_id')) {
            $business = Business::find($businessId);
            
            if (!$business) {
                $this->error("Business with ID {$businessId} not found!");
                return 1;
            }

            $this->info("Seeding defaults for: {$business->name}");
        } else {
            $businesses = Business::all();
            
            if ($businesses->isEmpty()) {
                $this->warn('No businesses found in the database.');
                $this->info('Please create a business first or run: php artisan db:seed');
                return 1;
            }

            $this->info("Found " . $businesses->count() . " business(es)");
        }

        $this->newLine();

        // Run seeders
        $this->call('db:seed', [
            '--class' => DefaultProductCategoriesSeeder::class
        ]);

        $this->call('db:seed', [
            '--class' => DefaultBusinessSettingsSeeder::class
        ]);

        $this->newLine();
        $this->info('✅ Default business configuration seeded successfully!');
        $this->newLine();
        $this->info('📊 Seeded:');
        $this->info('   • 10 Product Categories');
        $this->info('   • 5 Product Types');
        $this->info('   • 8 Units of Measurement');
        $this->info('   • 6 Payment Methods');
        $this->info('   • 5 Payment Statuses');
        $this->newLine();

        return 0;
    }
}

