<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculateDistanceFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            DROP FUNCTION IF EXISTS FU_CALCULAR_DISTANCIA;
            
            CREATE FUNCTION `FU_CALCULAR_DISTANCIA`(`v_latitud_origen` double,
            `v_latitud_destino` double,
            `v_longitud_origen` double,
            `v_longitud_destino` double) RETURNS float
                DETERMINISTIC
            BEGIN
              RETURN (SELECT
                  (ACOS(SIN(RADIANS(v_latitud_origen)) * SIN(RADIANS(v_latitud_destino)) +
                  COS(RADIANS(v_latitud_origen)) * COS(RADIANS(v_latitud_destino)) *
                  COS(RADIANS(v_longitud_origen) - RADIANS(v_longitud_destino))) * 6378) AS
                  DISTANCE);
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS FU_CALCULAR_DISTANCIA');
    }
}
