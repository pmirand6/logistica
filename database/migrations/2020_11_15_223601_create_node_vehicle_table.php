<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodeVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodeVehicle', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('relNodeId');
            $table->uuid('relVehicleId');
            $table->foreign('relNodeId')->references('nodeId')->on('nodes');
            $table->foreign('relVehicleId')->references('vehicleId')->on('vehicle');
            $table->unique(['relNodeId', 'relVehicleId'], 'node_vehicle_id');
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
        Schema::table('nodeVehicle', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
