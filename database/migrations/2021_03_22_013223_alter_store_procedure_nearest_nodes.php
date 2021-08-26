<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStoreProcedureNearestNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS SP_NODOS_CERCANOS;

            CREATE PROCEDURE `SP_NODOS_CERCANOS`(IN `latitude_client` double, IN `longitude_client` double, IN `km` int, IN `scope` INT)
            BEGIN
              SELECT
              n.nodeId,
              n.name,
              n.businessName,
              n.streetName,
              n.floor,
              n.departmentNumber,
              n.workDays,
              n.workHourStart,
              n.workHourEnd,
                CONCAT((SELECT
                    ROUND(FU_CALCULAR_DISTANCIA(latitude_client, n.latitude, longitude_client, n.longitude), 2))) AS distance_km
              FROM nodes n
              HAVING distance_km <= km
              ORDER BY distance_km ASC
              LIMIT 0, scope;
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
        //
    }
}
