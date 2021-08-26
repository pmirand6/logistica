<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryTypeVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryTypeVehicle', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('relDeliveryTypeId');
            $table->uuid('relVehicleId');
            $table->foreign('relDeliveryTypeId')->references('deliveryTypeId')->on('deliveryTypes');
            $table->foreign('relVehicleId')->references('vehicleId')->on('vehicle');
            $table->unique(['relDeliveryTypeId', 'relVehicleId'], 'delivery_type_vehicle_id');
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
        Schema::dropIfExists('delivery_type_vehicle');
    }
}
