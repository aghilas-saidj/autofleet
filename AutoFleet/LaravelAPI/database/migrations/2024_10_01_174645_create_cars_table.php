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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Car name or model
            $table->text('description');      // Description
            $table->decimal('price_per_day', 8, 2); // Rental price per day
            $table->string('image_path');     // Path to car image
            $table->string('type');           // Car type (e.g., SUV, Sedan)
            $table->integer('seats');         // Number of seats
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
