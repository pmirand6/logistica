<?php


namespace App\Repositories\Vehicle;

use Illuminate\Http\Request;


interface VehicleRepositoryInterface
{

    public function getAllActiveVehicle();

    public function getVehicleById($driverId);

    public function getVehicleByLicensePlate($licensePlate);

    public function deleteVehicle($driverId);

    public function updateVehicle(Request $request, $driverId);

    public function createVehicle($request);

    public function showNodesOfVehicle($vehicleId);

    public function showDeliveryTypesOfVehicle($vehicleId);

    public function vehicleDriverCreateRelation($vehicleId, $driverId);

    public function vehicleDriverDropRelation($vehicleId, $driverId);

    public function VehicleNodeDropRelation($vehicleId, $nodeId);

    public function showDriverOfVehicle($vehicleId);

    public function vehicleNodeCreateRelation($vehicleId, $nodeId);

    public function vehicleDeliveryTypeCreateRelation($vehicleId, $deliveryTypeId);

    public function uploadVehicleImages($vehiclePictures, $vehicle);

    public function dropVehiclePicture($vehicleId, $vehiclePictureId);
}
