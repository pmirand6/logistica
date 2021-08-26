<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle', function (Blueprint $table) {
            $table->uuid('vehicleId')->primary();
            $table->string('brand');
            $table->string('model');
            $table->string('licensePlate', 50)->unique();
            $table->char('year', 4)->nullable();
            $table->boolean('extern')->default(0);
            $table->time('workHourStart');
            $table->time('workHourEnd');
            $table->json('deliveryDays');
            $table->boolean('active')->default(1);
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
        Schema::table('vehicle', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
