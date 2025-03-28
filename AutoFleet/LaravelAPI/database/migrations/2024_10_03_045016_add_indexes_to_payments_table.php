<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->index('booking_id');        // Adding index to 'booking_id' column
            $table->index('payment_method');    // Adding index to 'payment_method' column
            $table->index('status');            // Adding index to 'status' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['booking_id']);        // Dropping index from 'booking_id' column
            $table->dropIndex(['payment_method']);    // Dropping index from 'payment_method' column
            $table->dropIndex(['status']);            // Dropping index from 'status' column
        });
    }
}
