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
        Schema::table('products', function (Blueprint $table) {
            // Change type column from ENUM to VARCHAR to support custom product types
            $table->string('type', 50)->default('product')->change();
            
            // Add missing columns that are in the controller validation
            if (!Schema::hasColumn('products', 'additional_info')) {
                $table->string('additional_info', 255)->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'tax_amount')) {
                $table->decimal('tax_amount', 15, 2)->default(0)->after('cost');
            }
            if (!Schema::hasColumn('products', 'other_costs')) {
                $table->decimal('other_costs', 15, 2)->default(0)->after('tax_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert type column back to ENUM (only if necessary)
            // Note: This may fail if custom types exist in the database
            // $table->enum('type', ['product', 'service'])->default('product')->change();
            
            // Drop the added columns
            if (Schema::hasColumn('products', 'additional_info')) {
                $table->dropColumn('additional_info');
            }
            if (Schema::hasColumn('products', 'tax_amount')) {
                $table->dropColumn('tax_amount');
            }
            if (Schema::hasColumn('products', 'other_costs')) {
                $table->dropColumn('other_costs');
            }
        });
    }
};
