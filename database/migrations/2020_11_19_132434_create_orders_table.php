<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('orderId')->primary();
            $table->string('orderCode');
            $table->string('deliveryType');
            $table->string('relShipping');
            $table->string('relVehicle');
            $table->string('relDriver');
            $table->string('roadMapCode')->nullable();
            $table->bigInteger('relUser')->unsigned();
            $table->string('status');
            $table->foreign('relShipping')->references('shippingId')->on('shippings');
            $table->foreign('relVehicle')->references('vehicleId')->on('vehicle');
            $table->foreign('relDriver')->references('driverId')->on('driver');
            $table->foreign('relUser')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
