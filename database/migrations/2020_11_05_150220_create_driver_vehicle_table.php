<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driverVehicle', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('relDriverId');
            $table->uuid('relVehicleId');
            $table->foreign('relDriverId')->references('driverId')->on('driver');
            $table->foreign('relVehicleId')->references('vehicleId')->on('vehicle');
            $table->boolean('status')->default(1);
            $table->unique(['relDriverId', 'relVehicleId'], 'driver_vehicle_id');
            $table->softDeletes();
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
        Schema::table('driverVehicle', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
