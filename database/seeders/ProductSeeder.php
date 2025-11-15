<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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

        // Create Product Categories
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and accessories'],
            ['name' => 'Clothing', 'description' => 'Apparel and fashion items'],
            ['name' => 'Food & Beverages', 'description' => 'Food and drink products'],
            ['name' => 'Home & Garden', 'description' => 'Home improvement and garden supplies'],
            ['name' => 'Software', 'description' => 'Digital software products'],
            ['name' => 'Services', 'description' => 'Professional services'],
        ];

        $createdCategories = [];
        foreach ($categories as $category) {
            $createdCategories[] = ProductCategory::create(array_merge($category, [
                'business_id' => $business->id,
                'is_active' => true,
            ]));
        }

        // Create Products with ArkSheet data structure
        $products = [
            // Electronics
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 01',
                'sku' => 'XX-P001',
                'description' => 'High-quality product item',
                'additional_info' => 'Premium',
                'type' => 'product',
                'price' => 999.00,
                'cost' => 450.00,
                'tax_amount' => 0.00,
                'other_costs' => 80.00,
                'stock_quantity' => 510,
                'min_stock_alert' => 20,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 02',
                'sku' => 'XX-P002',
                'description' => 'Premium electronic device',
                'type' => 'product',
                'price' => 1299.00,
                'cost' => 520.00,
                'tax_amount' => 0.00,
                'other_costs' => 90.00,
                'stock_quantity' => 370,
                'min_stock_alert' => 15,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 03',
                'sku' => 'XX-P003',
                'description' => 'Advanced tech gadget',
                'type' => 'product',
                'price' => 2199.00,
                'cost' => 980.00,
                'tax_amount' => 0.00,
                'other_costs' => 120.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 10,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 04',
                'sku' => 'XX-P004',
                'description' => 'Professional equipment',
                'type' => 'product',
                'price' => 1750.00,
                'cost' => 860.00,
                'tax_amount' => 0.00,
                'other_costs' => 80.00,
                'stock_quantity' => 180,
                'min_stock_alert' => 20,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 05',
                'sku' => 'XX-P005',
                'description' => 'Compact device',
                'type' => 'product',
                'price' => 860.00,
                'cost' => 420.00,
                'tax_amount' => 0.00,
                'other_costs' => 40.00,
                'stock_quantity' => 8,
                'min_stock_alert' => 15,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 06',
                'sku' => 'XX-P006',
                'description' => 'Versatile tool',
                'type' => 'product',
                'price' => 1250.00,
                'cost' => 620.00,
                'tax_amount' => 0.00,
                'other_costs' => 50.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 10,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 07',
                'sku' => 'XX-P007',
                'description' => 'Enhanced model',
                'type' => 'product',
                'price' => 1690.00,
                'cost' => 790.00,
                'tax_amount' => 0.00,
                'other_costs' => 60.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 12,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 08',
                'sku' => 'XX-P008',
                'description' => 'Standard edition',
                'type' => 'product',
                'price' => 1990.00,
                'cost' => 970.00,
                'tax_amount' => 0.00,
                'other_costs' => 80.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 15,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 09',
                'sku' => 'XX-P009',
                'description' => 'Essential accessory',
                'type' => 'product',
                'price' => 1120.00,
                'cost' => 560.00,
                'tax_amount' => 0.00,
                'other_costs' => 60.00,
                'stock_quantity' => 12,
                'min_stock_alert' => 8,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 10',
                'sku' => 'XX-P010',
                'description' => 'Budget-friendly option',
                'type' => 'product',
                'price' => 750.00,
                'cost' => 350.00,
                'tax_amount' => 0.00,
                'other_costs' => 40.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 10,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 11',
                'sku' => 'XX-P011',
                'description' => 'Entry-level product',
                'type' => 'product',
                'price' => 500.00,
                'cost' => 240.00,
                'tax_amount' => 0.00,
                'other_costs' => 30.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 5,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Product 12',
                'sku' => 'XX-P012',
                'description' => 'Flagship model',
                'type' => 'product',
                'price' => 1880.00,
                'cost' => 880.00,
                'tax_amount' => 0.00,
                'other_costs' => 70.00,
                'stock_quantity' => 230,
                'min_stock_alert' => 25,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'USB-C Cable',
                'sku' => 'ELEC-CABLE-001',
                'description' => '2m USB-C fast charging cable',
                'type' => 'product',
                'price' => 12.99,
                'cost' => 5.00,
                'stock_quantity' => 300,
                'min_stock_alert' => 50,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[0]->id,
                'name' => 'Bluetooth Speaker',
                'sku' => 'ELEC-SPEAK-001',
                'description' => 'Portable waterproof bluetooth speaker',
                'type' => 'product',
                'price' => 49.99,
                'cost' => 25.00,
                'stock_quantity' => 75,
                'min_stock_alert' => 10,
                'unit' => 'pcs',
            ],
            // Clothing
            [
                'product_category_id' => $createdCategories[1]->id,
                'name' => 'T-Shirt Basic',
                'sku' => 'CLOTH-TSHIRT-001',
                'description' => '100% cotton basic t-shirt',
                'type' => 'product',
                'price' => 19.99,
                'cost' => 8.00,
                'stock_quantity' => 200,
                'min_stock_alert' => 30,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[1]->id,
                'name' => 'Jeans Classic',
                'sku' => 'CLOTH-JEANS-001',
                'description' => 'Classic fit denim jeans',
                'type' => 'product',
                'price' => 59.99,
                'cost' => 30.00,
                'stock_quantity' => 100,
                'min_stock_alert' => 15,
                'unit' => 'pcs',
            ],
            // Food & Beverages
            [
                'product_category_id' => $createdCategories[2]->id,
                'name' => 'Organic Coffee Beans',
                'sku' => 'FOOD-COFFEE-001',
                'description' => '1kg premium organic coffee beans',
                'type' => 'product',
                'price' => 24.99,
                'cost' => 12.00,
                'stock_quantity' => 50,
                'min_stock_alert' => 10,
                'unit' => 'kg',
            ],
            [
                'product_category_id' => $createdCategories[2]->id,
                'name' => 'Green Tea Pack',
                'sku' => 'FOOD-TEA-001',
                'description' => 'Premium green tea - 50 bags',
                'type' => 'product',
                'price' => 15.99,
                'cost' => 7.00,
                'stock_quantity' => 80,
                'min_stock_alert' => 15,
                'unit' => 'pcs',
            ],
            // Home & Garden
            [
                'product_category_id' => $createdCategories[3]->id,
                'name' => 'LED Light Bulb',
                'sku' => 'HOME-LED-001',
                'description' => 'Energy efficient LED bulb 60W equivalent',
                'type' => 'product',
                'price' => 9.99,
                'cost' => 4.00,
                'stock_quantity' => 250,
                'min_stock_alert' => 40,
                'unit' => 'pcs',
            ],
            [
                'product_category_id' => $createdCategories[3]->id,
                'name' => 'Plant Pot Set',
                'sku' => 'HOME-POT-001',
                'description' => 'Ceramic plant pot set of 3',
                'type' => 'product',
                'price' => 34.99,
                'cost' => 18.00,
                'stock_quantity' => 40,
                'min_stock_alert' => 5,
                'unit' => 'set',
            ],
            // Software
            [
                'product_category_id' => $createdCategories[4]->id,
                'name' => 'Website Design Service',
                'sku' => 'SOFT-WEB-001',
                'description' => 'Custom website design and development',
                'type' => 'service',
                'price' => 1500.00,
                'cost' => 500.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 0,
                'unit' => 'project',
            ],
            [
                'product_category_id' => $createdCategories[4]->id,
                'name' => 'SEO Optimization',
                'sku' => 'SOFT-SEO-001',
                'description' => 'Search engine optimization service',
                'type' => 'service',
                'price' => 800.00,
                'cost' => 300.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 0,
                'unit' => 'project',
            ],
            // Services
            [
                'product_category_id' => $createdCategories[5]->id,
                'name' => 'Consulting - 1 Hour',
                'sku' => 'SERV-CONSULT-001',
                'description' => 'Business consulting service per hour',
                'type' => 'service',
                'price' => 150.00,
                'cost' => 0.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 0,
                'unit' => 'hour',
            ],
            [
                'product_category_id' => $createdCategories[5]->id,
                'name' => 'Training Workshop',
                'sku' => 'SERV-TRAIN-001',
                'description' => 'Full day training workshop',
                'type' => 'service',
                'price' => 2000.00,
                'cost' => 500.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 0,
                'unit' => 'day',
            ],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, [
                'business_id' => $business->id,
                'is_active' => true,
            ]));
        }

        $this->command->info('✓ Product Categories created!');
        $this->command->info('✓ ' . count($products) . ' Products created!');
    }
}
