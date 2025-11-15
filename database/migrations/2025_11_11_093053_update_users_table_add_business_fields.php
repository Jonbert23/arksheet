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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('business_id')->after('id')->nullable()->constrained('businesses')->onDelete('cascade');
            $table->string('role')->after('password')->default('staff'); // admin, manager, accountant, staff
            $table->string('phone')->after('email')->nullable();
            $table->string('avatar')->after('phone')->nullable();
            $table->boolean('is_active')->after('avatar')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
            $table->dropColumn(['business_id', 'role', 'phone', 'avatar', 'is_active']);
        });
    }
};
