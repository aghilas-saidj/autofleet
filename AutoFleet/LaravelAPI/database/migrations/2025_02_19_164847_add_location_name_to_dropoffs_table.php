<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dropoffs', function (Blueprint $table) {
            $table->string('location_name')->nullable()->after('location_id'); // Allow NULL to prevent errors
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dropoffs', function (Blueprint $table) {
            $table->dropColumn('location_name');
        });
    }
};
