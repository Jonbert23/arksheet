<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesChannel;
use App\Models\Business;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SalesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $business = Business::first();
        
        if (!$business) {
            $this->command->warn('⚠️  No business found. Please run BusinessSeeder first.');
            return;
        }

        $this->command->info('📊 Seeding sales data...');

        // Get all products and channels
        $products = Product::where('business_id', $business->id)->get();
        $channels = SalesChannel::where('business_id', $business->id)->get();
        
        if ($products->isEmpty() || $channels->isEmpty()) {
            $this->command->warn('⚠️  No products or channels found.');
            return;
        }

        // Create some customers
        $customers = [];
        for ($i = 0; $i < 10; $i++) {
            $customers[] = Customer::create([
                'business_id' => $business->id,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
        }

        // Generate 40 sales for testing
        $salesCount = 0;
        $numSales = 40;
        
        for ($i = 0; $i < $numSales; $i++) {
            // Random date within the current month
            $dayOfMonth = now()->day;
            $saleDate = now()->startOfMonth()->addDays(rand(0, $dayOfMonth - 1));
            
            // Random customer (or walk-in)
            $customer = rand(0, 3) == 0 ? null : $customers[array_rand($customers)];
            
            // Random channel
            $channel = $channels->random();
            
            // Create sale
            $sale = Sale::create([
                'business_id' => $business->id,
                'customer_id' => $customer ? $customer->id : null,
                'sales_channel_id' => $channel->id,
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'date' => $saleDate,
                'subtotal' => 0,
                'tax' => 0,
                'discount' => 0,
                'total' => 0,
                'payment_status' => $faker->randomElement(['paid', 'pending', 'partial']),
                'notes' => rand(0, 2) == 0 ? $faker->sentence : null,
            ]);

            // Add 1-5 items to the sale
            $numItems = rand(1, 5);
            $total = 0;
            
            for ($j = 0; $j < $numItems; $j++) {
                $product = $products->random();
                $quantity = rand(1, 5);
                $unitPrice = $product->price;
                $taxRate = $product->tax_amount; // Tax rate as percentage
                $itemSubtotal = $quantity * $unitPrice;
                $taxAmount = $itemSubtotal * ($taxRate / 100);
                $itemTotal = $itemSubtotal + $taxAmount;
                $itemCost = $quantity * $product->cost;
                $itemProfit = $itemTotal - $itemCost;
                
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'tax_rate' => $taxRate,
                    'tax_amount' => $taxAmount,
                    'subtotal' => $itemSubtotal,
                    'total' => $itemTotal,
                    'cost' => $itemCost,
                    'profit' => $itemProfit,
                ]);
                
                $total += $itemSubtotal;
            }

            // Update sale totals
            $discount = $total * (rand(0, 10) / 100); // 0-10% discount
            $taxAmount = ($total - $discount) * 0.1; // 10% tax
            $finalTotal = $total - $discount + $taxAmount;
            
            $sale->update([
                'subtotal' => $total,
                'discount' => $discount,
                'tax' => $taxAmount,
                'total' => $finalTotal,
            ]);
            
            $salesCount++;
        }

        $this->command->info("✅ Created {$salesCount} sales with items");
    }
}

