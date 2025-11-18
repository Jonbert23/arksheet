<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration updates the user roles to support the Super Admin implementation:
     * - Changes existing 'admin' role to 'business_owner'
     * - Prepares the system for the new 'super_admin' role
     */
    public function up(): void
    {
        // Update all existing users with role 'admin' to 'business_owner'
        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'business_owner']);
        
        // Log the number of users updated
        $updatedCount = DB::table('users')
            ->where('role', 'business_owner')
            ->count();
        
        if ($updatedCount > 0) {
            echo "✓ Updated {$updatedCount} admin user(s) to business_owner role\n";
        }
    }

    /**
     * Reverse the migrations.
     * 
     * Rollback changes:
     * - Revert 'business_owner' back to 'admin'
     * - Remove any 'super_admin' users created
     */
    public function down(): void
    {
        // Revert business_owner back to admin
        DB::table('users')
            ->where('role', 'business_owner')
            ->update(['role' => 'admin']);
        
        // Delete any super_admin users (cleanup)
        DB::table('users')
            ->where('role', 'super_admin')
            ->delete();
        
        echo "✓ Rolled back role changes\n";
    }
};

