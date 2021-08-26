<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoadMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_maps', function (Blueprint $table) {
            $table->uuid('road_map_id')->primary();
            $table->string('rel_picking_order');
            $table->string('road_map_code');
            $table->string('rel_driver_id');
            $table->foreign('rel_driver_id')->references('driverId')->on('driver');
            $table->foreign('rel_picking_order')->references('orderId')->on('orders');
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
        Schema::dropIfExists('road_maps');
    }
}
