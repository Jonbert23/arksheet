<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates the default Super Admin account for the application.
     * This account has system-wide access and can manage all businesses.
     */
    public function run(): void
    {
        // Check if Super Admin already exists
        $existingSuperAdmin = User::where('email', 'superadmin@arksheet.com')->first();
        
        if ($existingSuperAdmin) {
            $this->command->warn('⚠️  Super Admin account already exists!');
            $this->command->info('Email: superadmin@arksheet.com');
            return;
        }
        
        // Create Super Admin account
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@arksheet.com',
            'password' => Hash::make('SuperAdmin@123'),
            'role' => 'super_admin',
            'business_id' => null, // Super Admin has no business
            'is_active' => true,
            'phone' => null,
            'avatar' => null,
            'permissions' => null,
        ]);
        
        // Display success message with credentials
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('✓ Super Admin account created successfully!');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('');
        $this->command->info('📧 Email:    superadmin@arksheet.com');
        $this->command->info('🔑 Password: SuperAdmin@123');
        $this->command->info('');
        $this->command->warn('⚠️  IMPORTANT: Please change the password after first login!');
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════');
    }
}

