<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\SalesChannel;
use Illuminate\Database\Seeder;

class SalesChannelSeeder extends Seeder
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

        $channels = [
            [
                'name' => 'Physical Store',
                'description' => 'Main retail store location',
            ],
            [
                'name' => '2nd Branch',
                'description' => 'Secondary store location',
            ],
            [
                'name' => 'Online Store',
                'description' => 'E-commerce website',
            ],
            [
                'name' => 'Shopify',
                'description' => 'Shopify marketplace',
            ],
            [
                'name' => 'TikTok',
                'description' => 'TikTok Shop',
            ],
            [
                'name' => 'Facebook Marketplace',
                'description' => 'Facebook marketplace sales',
            ],
            [
                'name' => 'Instagram',
                'description' => 'Instagram shop',
            ],
        ];

        foreach ($businesses as $business) {
            $this->command->info("Seeding sales channels for: {$business->name}");

            foreach ($channels as $channel) {
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

            $this->command->info("  ✓ Created " . count($channels) . " sales channels");
        }

        $this->command->info("\n✅ Sales channels seeded successfully!");
    }
}
