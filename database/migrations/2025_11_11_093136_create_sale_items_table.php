<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2); // Price per unit
            $table->decimal('tax_rate', 5, 2)->default(0); // Tax rate percentage (e.g., 10.00 for 10%)
            $table->decimal('tax_amount', 15, 2)->default(0); // Calculated tax amount
            $table->decimal('subtotal', 15, 2); // Quantity × Unit Price
            $table->decimal('total', 15, 2); // Subtotal + Tax
            $table->decimal('cost', 15, 2)->default(0); // Cost basis for profit calculation
            $table->decimal('profit', 15, 2)->default(0); // Total - Cost
            $table->timestamps();
            
            $table->index('sale_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
