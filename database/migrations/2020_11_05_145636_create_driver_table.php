<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver', function (Blueprint $table) {
            $table->uuid('driverId')->primary();
            $table->string('identityDocument')->unique();
            $table->string('lastName');
            $table->string('name');
            $table->string('email');
            $table->string('areaCode', 20);
            $table->string('phone', 50);
            $table->string('driverPicture')->nullable();
            $table->boolean('status')->default(0);
            $table->string('postalCode', 50);
            $table->string('address');
            $table->integer('provinceId')->nullable();
            $table->integer('countryId')->nullable();
            $table->boolean('active')->default(1);
            $table->index('identityDocument');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['identityDocument', 'email'], 'driver_mail_id');
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
        Schema::table('driver', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
