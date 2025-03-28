<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToCarsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->index('type');           // Adding index to 'type' column
            $table->index('seats');          // Adding index to 'seats' column
            $table->index('price_per_day');          // Adding index to 'price_per_day' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex(['type']);     // Dropping the index on 'type' column
            $table->dropIndex(['seats']);    // Dropping the index on 'seats' column
            $table->dropIndex(['price_per_day']);    // Dropping the index on 'price_per_day' column

        });
    }
}
