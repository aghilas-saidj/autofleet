<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookingsTableAddReferenceCodeAndEmailAddress extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('reference_code')->nullable()->unique()->after('additional_info'); // Make it nullable
            $table->string('email_address')->nullable()->after('reference_code'); // Email address
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['reference_code', 'email_address']); // Drop the added columns
        });
    }
}
