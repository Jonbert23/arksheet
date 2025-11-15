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
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('quantity', 15, 2)->default(0);
            $table->string('unit'); // kg, liter, pieces, etc
            $table->decimal('cost_per_unit', 15, 2)->default(0);
            $table->decimal('total_value', 15, 2)->default(0);
            $table->string('supplier')->nullable();
            $table->decimal('min_stock', 15, 2)->default(0);
            $table->date('last_purchased_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('business_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
