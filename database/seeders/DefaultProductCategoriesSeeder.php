<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class DefaultProductCategoriesSeeder extends Seeder
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

        // Default Product Categories
        $defaultCategories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories',
                'is_active' => true,
            ],
            [
                'name' => 'Clothing & Apparel',
                'description' => 'Clothing, shoes, and fashion accessories',
                'is_active' => true,
            ],
            [
                'name' => 'Food & Beverages',
                'description' => 'Food products and beverages',
                'is_active' => true,
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement and garden supplies',
                'is_active' => true,
            ],
            [
                'name' => 'Health & Beauty',
                'description' => 'Health products and beauty items',
                'is_active' => true,
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'is_active' => true,
            ],
            [
                'name' => 'Books & Media',
                'description' => 'Books, magazines, and media content',
                'is_active' => true,
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Toys, games, and entertainment',
                'is_active' => true,
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Office equipment and supplies',
                'is_active' => true,
            ],
            [
                'name' => 'Automotive',
                'description' => 'Auto parts and accessories',
                'is_active' => true,
            ],
        ];

        foreach ($businesses as $business) {
            $this->command->info("Seeding default data for business: {$business->name}");

            // Seed Product Categories
            foreach ($defaultCategories as $category) {
                ProductCategory::firstOrCreate(
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

            $this->command->info("  ✓ Created " . count($defaultCategories) . " product categories");
        }

        $this->command->info("\n✅ Default product categories seeded successfully!");
    }
}

