<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\ProductCategory;
use App\Models\BusinessSetting;
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

        // Default Product Types (Business Settings)
        $defaultProductTypes = [
            [
                'setting_key' => 'product_type',
                'setting_value' => 'physical',
                'setting_label' => 'Physical Product',
                'description' => 'Tangible products that require inventory management and shipping',
                'sort_order' => 1,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'product_type',
                'setting_value' => 'digital',
                'setting_label' => 'Digital Product',
                'description' => 'Digital products like software, ebooks, or downloadable content',
                'sort_order' => 2,
                'is_active' => true,
                'is_system' => true,
            ],
            [
                'setting_key' => 'product_type',
                'setting_value' => 'service',
                'setting_label' => 'Service',
                'description' => 'Service-based products like consulting or maintenance',
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
            [
                'setting_key' => 'product_type',
                'setting_value' => 'bundle',
                'setting_label' => 'Bundle/Package',
                'description' => 'Combination of multiple products sold as a package',
                'sort_order' => 5,
                'is_active' => true,
                'is_system' => false,
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
        }

        $this->command->info("\n✅ Default product categories and types seeded successfully!");
    }
}

