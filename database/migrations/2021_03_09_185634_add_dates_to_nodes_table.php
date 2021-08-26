<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatesToNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nodes', function (Blueprint $table) {
            $table->json('workDays')->after('businessName');
            $table->time('workHourStart')->after('workDays');
            $table->time('workHourEnd')->after('workHourStart');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nodes', function (Blueprint $table) {
            $table->dropColumn('workDays');
            $table->dropColumn('workHourStart');
            $table->dropColumn('workHourEnd');

        });
    }
}
