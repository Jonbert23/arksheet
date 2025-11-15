<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Business;
use App\Models\Product;
use App\Models\StockIn;
use Faker\Factory as Faker;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->command->info('📦 Seeding stock data...');
        $faker = Faker::create();
        $business = Business::first();
        $products = Product::where('type', 'product')->get();

        if (!$business || $products->isEmpty()) {
            $this->command->error('No business or products found. Please run BusinessSeeder and ProductSeeder first.');
            return;
        }

        $suppliers = [
            'ABC Wholesale Inc.',
            'Global Supplies Co.',
            'Premium Distributors',
            'Direct Import Trading',
            'Quality Goods Supplier',
            'Fast Logistics Corp.',
            'Reliable Partners Ltd.',
            'Express Delivery Services',
        ];

        $stockCount = 0;

        // Create stock entries for the last 6 months
        for ($m = 5; $m >= 0; $m--) {
            $month = now()->subMonths($m);
            $numEntries = rand(8, 15); // 8-15 stock entries per month

            for ($i = 0; $i < $numEntries; $i++) {
                $product = $products->random();
                $entryDate = $month->copy()->startOfMonth()->addDays(rand(0, $month->daysInMonth - 1));
                
                // Random quantity based on product type
                $quantity = rand(10, 200);
                
                // Cost variation (90%-110% of product cost)
                $costVariation = $product->cost * (rand(90, 110) / 100);
                $costPerUnit = max(1, $costVariation);
                
                // Calculate total cost
                $totalCost = $quantity * $costPerUnit;

                // Generate reference number
                $refNumber = 'PO-' . strtoupper($month->format('MY')) . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);

                StockIn::create([
                    'business_id' => $business->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'cost_per_unit' => $costPerUnit,
                    'total_cost' => $totalCost,
                    'supplier' => $suppliers[array_rand($suppliers)],
                    'reference_number' => $refNumber,
                    'date' => $entryDate,
                    'notes' => rand(0, 3) == 0 ? $faker->sentence : null,
                ]);

                $stockCount++;
            }
        }

        $this->command->info('✅ Created ' . $stockCount . ' stock entries');
    }
}

