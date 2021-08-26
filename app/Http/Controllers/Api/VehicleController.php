<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Vehicle\VehicleRepositoryInterface;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $vehicleInterface;

    public function __construct(VehicleRepositoryInterface $vehicleInterface)
    {
        $this->vehicleInterface = $vehicleInterface;
    }

    public function index()
    {
        return $this->vehicleInterface->getAllActiveVehicle();
    }

    public function show($vehicleId)
    {
        return $this->vehicleInterface->getVehicleById($vehicleId);
    }

    public function createVehicle(Request $request)
    {
        return $this->vehicleInterface->createVehicle($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $vehicleId
     * @return void
     */
    public function updateVehicle(Request $request, $vehicleId)
    {
        return $this->vehicleInterface->updateVehicle($request, $vehicleId);

    }

    public function VehicleDriverCreateRelation($vehicleId, $driverId)
    {
        return $this->vehicleInterface->vehicleDriverCreateRelation($vehicleId, $driverId);
    }

    public function VehicleDriverDropRelation($vehicleId, $driverId)
    {
        return $this->vehicleInterface->vehicleDriverDropRelation($vehicleId, $driverId);
    }

    public function showDriverOfVehicle($vehicleId)
    {
        return $this->vehicleInterface->showDriverOfVehicle($vehicleId);
    }

    public function showNodesOfVehicle($vehicleId)
    {
        return $this->vehicleInterface->showNodesOfVehicle($vehicleId);
    }

    public function VehicleNodeCreateRelation($vehicleId, $nodeId)
    {
        return $this->vehicleInterface->vehicleNodeCreateRelation($vehicleId, $nodeId);
    }

    public function showDeliveryTypesOfVehicle($vehicleId)
    {
        return $this->vehicleInterface->showDeliveryTypesOfVehicle($vehicleId);
    }

    public function VehicleDeliveryTypeCreateRelation($vehicleId, $deliveryTypeId)
    {
        return $this->vehicleInterface->VehicleDeliveryTypeCreateRelation($vehicleId, $deliveryTypeId);
    }

    public function getVehicleByLicensePlate($vehicleLicense)
    {
        return $this->vehicleInterface->getVehicleByLicensePlate($vehicleLicense);
    }

    public function VehicleNodeDropRelation($vehicleId, $nodeId)
    {
        return $this->vehicleInterface->VehicleNodeDropRelation($vehicleId, $nodeId);
    }

    public function uploadVehicleImages(Request $request, $vehicleId)
    {
        return $this->vehicleInterface->uploadVehicleImages($request, $vehicleId);
    }

    public function dropVehiclePicture($vehicleId, $vehiclePictureId)
    {
        return $this->vehicleInterface->dropVehiclePicture($vehicleId, $vehiclePictureId);
    }

}
