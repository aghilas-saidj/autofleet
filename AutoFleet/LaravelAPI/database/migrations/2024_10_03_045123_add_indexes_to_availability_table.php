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
        Schema::table('availability', function (Blueprint $table) {
            $table->index('car_id');           // Add index to 'car_id' column
            $table->index('available_from');   // Add index to 'available_from' column
            $table->index('available_to');     // Add index to 'available_to' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availability', function (Blueprint $table) {
            $table->dropIndex(['car_id']);           // Drop index from 'car_id' column
            $table->dropIndex(['available_from']);   // Drop index from 'available_from' column
            $table->dropIndex(['available_to']);     // Drop index from 'available_to' column
        });
    }
};
