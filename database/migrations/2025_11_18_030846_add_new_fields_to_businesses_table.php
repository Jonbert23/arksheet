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
        Schema::table('businesses', function (Blueprint $table) {
            // Add location fields after address
            if (!Schema::hasColumn('businesses', 'city')) {
                $table->string('city')->nullable()->after('address');
            }
            if (!Schema::hasColumn('businesses', 'state')) {
                $table->string('state')->nullable()->after('city');
            }
            if (!Schema::hasColumn('businesses', 'postal_code')) {
                $table->string('postal_code', 20)->nullable()->after('state');
            }
            
            // Add country field
            if (!Schema::hasColumn('businesses', 'country')) {
                $table->string('country')->default('Philippines')->after('postal_code');
            }
            
            // Add tax_id field
            if (!Schema::hasColumn('businesses', 'tax_id')) {
                $table->string('tax_id')->nullable()->after('timezone');
            }
            
            // Add business_type field
            if (!Schema::hasColumn('businesses', 'business_type')) {
                $table->string('business_type')->nullable();
            }
            
            // Add business_hours if it doesn't exist
            if (!Schema::hasColumn('businesses', 'business_hours')) {
                $table->string('business_hours')->nullable();
            }
            
            // Add business info fields
            if (!Schema::hasColumn('businesses', 'employees')) {
                $table->string('employees', 50)->nullable();
            }
            if (!Schema::hasColumn('businesses', 'years_in_business')) {
                $table->string('years_in_business', 50)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            // Drop columns only if they exist
            if (Schema::hasColumn('businesses', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('businesses', 'state')) {
                $table->dropColumn('state');
            }
            if (Schema::hasColumn('businesses', 'postal_code')) {
                $table->dropColumn('postal_code');
            }
            if (Schema::hasColumn('businesses', 'country')) {
                $table->dropColumn('country');
            }
            if (Schema::hasColumn('businesses', 'tax_id')) {
                $table->dropColumn('tax_id');
            }
            if (Schema::hasColumn('businesses', 'business_type')) {
                $table->dropColumn('business_type');
            }
            if (Schema::hasColumn('businesses', 'employees')) {
                $table->dropColumn('employees');
            }
            if (Schema::hasColumn('businesses', 'years_in_business')) {
                $table->dropColumn('years_in_business');
            }
            if (Schema::hasColumn('businesses', 'business_hours')) {
                $table->dropColumn('business_hours');
            }
        });
    }
};
