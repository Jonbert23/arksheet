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
        $business = Business::first();

        if (!$business) {
            $this->command->error('No business found. Please run BusinessSeeder first.');
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

        foreach ($channels as $channel) {
            SalesChannel::create(array_merge($channel, [
                'business_id' => $business->id,
                'is_active' => true,
            ]));
        }

        $this->command->info('✓ Sales Channels created!');
    }
}
