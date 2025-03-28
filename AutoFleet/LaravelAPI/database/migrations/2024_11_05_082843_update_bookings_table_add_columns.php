<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookingsTableAddColumns extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change(); // Make user_id nullable
            $table->enum('type', ['guest', 'registered_user', 'added_by_admin'])->default('guest')->after('status'); // Add type column with default
            $table->text('additional_info')->nullable()->after('type'); // Add additional_info column
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('type'); // Drop type column
            $table->dropColumn('additional_info'); // Drop additional_info column
            $table->foreignId('user_id')->nullable(false)->change(); // Change user_id back to non-nullable
        });
    }
}
