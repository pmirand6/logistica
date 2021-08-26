<?php


namespace App\Repositories\DeliveryType;


interface DeliveryTypeRepositoryInterface
{
    public function getAllDeliveryTypes();

    public function DeliveryTypeVehicleDropRelation($deliveryTypeId, $vehicleId);

}
