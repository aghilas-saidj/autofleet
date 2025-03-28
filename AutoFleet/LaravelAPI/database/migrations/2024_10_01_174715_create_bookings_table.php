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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade')->index()->name('fk_bookings_car_id'); // Foreign key to cars table
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->index()->name('fk_bookings_user_id'); // Foreign key to users table
            $table->date('start_date');      // Booking start date
            $table->date('end_date');        // Booking end date
            $table->decimal('total_price', 8, 2); // Total booking price
            $table->enum('status', ['pending', 'confirmed', 'canceled']); // Booking status
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};