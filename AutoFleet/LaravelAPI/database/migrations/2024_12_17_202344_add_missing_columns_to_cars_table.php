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
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('bags')->nullable(); // Number of bags
            $table->integer('doors')->nullable(); // Number of doors
            $table->boolean('airconditioning')->default(false); // Air conditioning availability
            $table->string('transmission')->nullable(); // Transmission type
            $table->string('engine_type')->nullable(); // Engine type
            $table->decimal('refundable_security_deposit', 10, 2)->nullable(); // Security deposit
            $table->string('included_insurance')->nullable(); // Included insurance details
            $table->string('fuel_policy')->nullable(); // Fuel policy
            $table->boolean('is_unlimited_mileage')->default(false); // Unlimited mileage option
            $table->integer('mileage')->nullable(); // Mileage
            $table->string('collision_damage_waiver')->nullable(); // Collision damage waiver
            $table->string('Theft_Protection')->nullable(); // Theft protection
            $table->string('roadside_assistance')->nullable(); // Roadside assistance
            $table->string('third_party_liability')->nullable(); // Third-party liability
            $table->text('better_to_know')->nullable(); // Additional information
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn([
                'bags',
                'doors',
                'airconditioning',
                'transmission',
                'engine_type',
                'refundable_security_deposit',
                'included_insurance',
                'fuel_policy',
                'is_unlimited_mileage',
                'mileage',
                'collision_damage_waiver',
                'Theft_Protection',
                'roadside_assistance',
                'third_party_liability',
                'better_to_know',
            ]);
        });
    }
};
