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
        Schema::table('stock_ins', function (Blueprint $table) {
            $table->decimal('shipping_cost', 15, 2)->default(0)->after('total_cost');
            $table->decimal('import_duties', 15, 2)->default(0)->after('shipping_cost');
            $table->decimal('other_transaction_costs', 15, 2)->default(0)->after('import_duties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_ins', function (Blueprint $table) {
            $table->dropColumn(['shipping_cost', 'import_duties', 'other_transaction_costs']);
        });
    }
};
