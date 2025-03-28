<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsUnderMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars_under_maintenance', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('car_id'); // Foreign key to cars table
            $table->text('reason'); // Reason for maintenance
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraint
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars_under_maintenance');
    }
}

