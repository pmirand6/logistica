<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProviderEmailToShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shippings', function (Blueprint $table) {
            $table->string('providerEmail')->after('deliveryType');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shippings', function (Blueprint $table) {
            $table->dropColumn('providerEmail');
        });
    }
}
