<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->uuid('shippingId')->primary();
            $table->string('shippingCode');
            $table->string('purchaseOrder')
                ->comment('Refers to the Purchase Order Number given by Store Service')->nullable();
            $table->string('pickingOrderCode')
                ->nullable()
                ->comment('Refers to Order Table');
            $table->uuid('node_id');
            $table->string('customerDeliveryAddress')
                ->nullable()
                ->comment('Refers to customer delivery address, it can be null if the delivery type chosen was node');
            $table->string('providerAddress');
            $table->dateTime('estimatedDeliveryDate')
                ->comment('Delivery Date Estimated by Tienda Service');
            $table->string('status');
            $table->dateTime('orderDate');
            $table->string('product');
            $table->integer('quantity');
            $table->string('clientName');
            $table->string('productImageUrl');
            $table->string('qrCode')->nullable(); //FIXME CUANDO SE ENCUENTRE CORRECTAMENTE IMPLEMENTADO, DEBE SER REQUERIDO
            $table->boolean('requiresCold')->default(0);
            $table->enum('deliveryType', ['delivery', 'node', 'takeaway']);
            $table->foreign('node_id')
                ->references('nodeId')->on('nodes');
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
        Schema::dropIfExists('shippings');
    }
}
