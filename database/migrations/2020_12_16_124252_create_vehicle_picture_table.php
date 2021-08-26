<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclePictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiclePicture', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('relVehicleId');
            $table->string('vehiclePicture');
            $table->foreign('relVehicleId')->references('vehicleId')->on('vehicle');
            $table->timestamps();
            $table->collation = 'utf8mb4_0900_ai_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiclePicture');
    }
}
