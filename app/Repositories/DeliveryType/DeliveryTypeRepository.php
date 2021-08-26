<?php


namespace App\Repositories\DeliveryType;

use App\Manager\ResponseManager;
use App\Models\DeliveryType\DeliveryType;
use App\Models\DeliveryTypeVehicle;
use App\Models\Order\Order;
use App\Models\Vehicle\Vehicle;
use App\Resources\DeliveryType\DeliveryTypeResource;
use App\Resources\Vehicle\VehicleCollection;
use App\Resources\VehicleDriver\VehicleDriverResource;

class DeliveryTypeRepository implements DeliveryTypeRepositoryInterface
{

    public function getAllDeliveryTypes()
    {
        try {
            return DeliveryTypeResource::collection(DeliveryType::paginate());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $deliveryTypeId
     * @param $vehicleId
     * @return VehicleDriverResource|string
     */
    public function DeliveryTypeVehicleDropRelation($deliveryTypeId, $vehicleId)
    {
        try {
            $vehicle = Vehicle::findOrFail($vehicleId);
            $deliveryType = DeliveryType::findOrFail($deliveryTypeId);

            $deliveryType->vehicle()->detach($vehicleId);
            //TODO VERIFICAR EN ORDENES SI HAY UN VEHICULO EN USO
            //DEBEN ESTAR CLAROS LOS ESTADOS PARA PODER HACER ESTE FILTRO
            //Order::where('relVehicle', $vehicleId)

            DeliveryTypeVehicle::where('relVehicleId', $vehicleId)->where('relDeliveryTypeId', $deliveryTypeId)
                ->delete();
            return new VehicleCollection($vehicle);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}
