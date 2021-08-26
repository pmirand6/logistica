<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {

        $table->uuid('nodeId')->primary();
        $table->string('name',100);
        $table->string('businessName',100);
        $table->string('geo',100);
        $table->float('latitude', 10, 6);
        $table->float('longitude', 10, 6);
        $table->string('streetName',128);
        $table->string('floor',10)->nullable()->default('NULL');
        $table->string('departmentNumber',6)->nullable()->default('NULL');
        $table->string('logo',100)->nullable()->default('NULL');
        $table->string('phoneNumber',100);
        $table->string('email',150);
        $table->boolean('active')->default(1);
        $table->unsignedInteger('localitiesId');
        $table->softDeletes();
        $table->timestamps();
        $table->collation = 'utf8mb4_0900_ai_ci';
        });
    }

    public function down()
    {
        Schema::table('nodes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
