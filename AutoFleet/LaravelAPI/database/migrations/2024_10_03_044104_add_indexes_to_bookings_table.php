<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Adding indexes
            $table->index('car_id');       // Index for 'car_id'
            $table->index('user_id');      // Index for 'user_id'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Dropping the indexes in case of rollback
            $table->dropIndex(['car_id']);       
            $table->dropIndex(['user_id']);      
        });
    }
}
