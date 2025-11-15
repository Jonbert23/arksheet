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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Assignee
            $table->string('name');
            $table->text('description')->nullable();
            
            // Goal Type
            $table->enum('goal_type', [
                'sales_revenue',
                'sales_volume',
                'product_sales',
                'customer_acquisition',
                'expense_reduction',
                'profit_margin',
                'custom'
            ])->default('sales_revenue');
            
            // Target and Current Values
            $table->decimal('target_amount', 15, 2);
            $table->decimal('current_amount', 15, 2)->default(0);
            
            // Time Period
            $table->date('start_date');
            $table->date('end_date');
            
            // Priority
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            
            // Status
            $table->enum('status', ['active', 'paused', 'completed', 'failed'])->default('active');
            
            // Additional Filters (for specific goal types)
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('sales_channel_id')->nullable()->constrained()->onDelete('set null');
            
            // Progress tracking
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('business_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('goal_type');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
