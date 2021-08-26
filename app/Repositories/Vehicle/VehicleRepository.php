<?php


namespace App\Repositories\Vehicle;


use App\Manager\ImageManager;
use App\Models\DeliveryType\DeliveryType;
use App\Models\Driver\Driver;
use App\Models\DriverVehicle;
use App\Models\Node\Node;
use App\Models\NodeVehicle;
use App\Models\VehiclePicture\VehiclePicture;
use App\Models\Vehicle\Vehicle;
use App\Resources\Vehicle\VehicleCollection;
use App\Resources\Vehicle\VehicleResource;
use App\Resources\VehicleDriver\VehicleDriverResource;
use App\Resources\VehicleNodes\VehicleNodesResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VehicleRepository implements VehicleRepositoryInterface
{
    public function getAllActiveVehicle()
    {
        try {
            return VehicleCollection::collection(Vehicle::paginate(6));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getVehicleById($vehicleId)
    {
        try {
            $vehicle = Vehicle::where('vehicleId', $vehicleId)->firstOrFail();
            if (!$vehicle) {
                throw new \Exception('Vehiculo No Encontrado o Deshabilitado');
            }
            return new VehicleResource($vehicle);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getVehicleByLicensePlate($vehicleLicense)
    {
        $vehicles = Vehicle::whereLike('licensePlate', $vehicleLicense)->get();
        return VehicleResource::collection($vehicles);

    }

    public function deleteVehicle($driverId)
    {
        // TODO: Implement deleteVehicle() method.
    }

    public function updateVehicle(Request $request, $vehicleId)
    {
        try {
            $vehicle = Vehicle::where('vehicleId', $vehicleId)->firstOrFail();

            $vehicle->update([
                'brand' => $request->brand,
                'model' => $request->model,
                'licensePlate' => $request->license_plate,
                'workHourStart' => $request->start_work,
                'workHourEnd' => $request->end_work,
                'deliveryDays' => $request->delivery_days,
                'extern' => $request->extern,
                'year' => $request->year,
                'active' => $request->active,
            ]);

            if ($request->has('delivery_types')) {
                $vehicle->deliveryType()->sync([]);
                foreach ($request->input('delivery_types') as $d) {
                    $dt = DeliveryType::where('name', $d)->get('deliveryTypeId');
                    $vehicle->deliveryType()->attach($dt[0]["deliveryTypeId"]);
                }
            }

            if ($request->has('new_vehicle_pictures')) {
                $this->uploadVehicleImages($request->new_vehicle_pictures, $vehicle);
            }

            return new VehicleResource($vehicle);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function createVehicle($request)
    {
        //TODO CREAR VALIDACION

        if ($request->has('delivery_days')) {
            $delivery_days = implode(',', $request->delivery_days);
        }

        try {
            $vehicle = Vehicle::create([
                'brand' => $request->brand,
                'model' => $request->model,
                'licensePlate' => $request->license_plate,
                'workHourStart' => $request->start_work,
                'workHourEnd' => $request->end_work,
                'deliveryDays' => $request->delivery_days,
                'extern' => $request->extern,
                'year' => $request->year,
            ]);

            if ($request->has('nodes')) {
                foreach ($request->input('nodes') as $n) {
                    $vehicle->node()->attach($n);
                }
            }

            if ($request->has('delivery_types')) {
                foreach ($request->input('delivery_types') as $d) {
                    $dt = DeliveryType::where('name', $d)->get('deliveryTypeId');
                    $vehicle->deliveryType()->attach($dt[0]["deliveryTypeId"]);
                }
            }

            if ($request->has('vehicle_pictures')) {
                $this->uploadVehicleImages($request->vehicle_pictures, $vehicle);
            }

            return new VehicleResource($vehicle);

        } catch (QueryException $e) {
            return $e->getMessage();
        }

    }

    public function showNodesOfVehicle($vehicleId)
    {
        try {
            //TODO CREAR VALIDACIONES
            $vehicle = (new Vehicle)->where('active', '=', '1')->find($vehicleId);
            if (!$vehicle) {
                throw new \Exception('Vehiculo no encontrado/deshabilitado');
            }
            return new VehicleNodesResource($vehicle);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function vehicleDriverCreateRelation($vehicleId, $driverId)
    {
        try {
            $driver = (new Driver)->where('active', '1')->find($driverId);
            $vehicle = (new Vehicle)->where('active', '1')->find($vehicleId);
            if (!$driver) {
                throw new \Exception('Conductor no encontrado/deshabilitado');
            }
            if (!$vehicle) {
                throw new \Exception('Vehiculo no encontrado/deshabilitado');
            }
            $vehicle->driver()->attach($driver);

            return new VehicleDriverResource($vehicle);

        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $vehicleId
     * @param $driverId
     * @return mixed
     */
    public function vehicleDriverDropRelation($vehicleId, $driverId)
    {
        try {
            $vehicle = Vehicle::findOrFail($vehicleId);
            $driver = Driver::findOrFail($driverId);
            $vehicle->driver()->detach($driverId);
            DriverVehicle::where('relVehicleId', $vehicleId)->where('relDriverId', $driverId)
                ->delete();
            return new VehicleDriverResource($vehicle);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function VehicleNodeDropRelation($vehicleId, $nodeId)
    {
        try {
            $vehicle = Vehicle::findOrFail($vehicleId);
            $node = Node::findOrFail($nodeId);
            $vehicle->node()->detach($nodeId);
            nodeVehicle::where('relVehicleId', $vehicleId)->where('relNodeId', $nodeId)
                ->delete();
            return new VehicleNodesResource($vehicle);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function showDriveNodeResourcerOfVehicle($vehicleId)
    {
        try {
            //TODO CREAR VALIDACIONES
            $vehicle = Vehicle::where('active', '1')->find($vehicleId);
            if (!$vehicle) {
                throw new \Exception('Vehiculo No Encontrado o Deshabilitado');
            }
            return new VehicleDriverResource($vehicle);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function vehicleNodeCreateRelation($vehicleId, $nodeId)
    {
        try {
            $node = Node::where('active', '1')->find($nodeId);
            $vehicle = Vehicle::where('active', '1')->find($vehicleId);
            if (!$node) {
                throw new \Exception('Nodo No Admitido o No Habilitado');
            }
            if (!$vehicle) {
                throw new \Exception('Vehiculo No Admitido');
            }
            $vehicle->node()->attach($node);
            return new VehicleNodesResource($vehicle);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function showDeliveryTypesOfVehicle($vehicleId)
    {
        try {
            //TODO CREAR VALIDACIONES
            $vehicle = Vehicle::where('active', '=', '1')->find($vehicleId);
            if (!$vehicle) {
                throw new \Exception('Vehiculo no encontrado/deshabilitado');
            }
            return new VehicleNodesResource($vehicle);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function vehicleDeliveryTypeCreateRelation($vehicleId, $deliveryTypeId)
    {
        try {
            $deliveryType = Node::find($deliveryTypeId);
            $vehicle = Vehicle::where('active', '1')->find($vehicleId);
            if (!$deliveryType) {
                throw new \Exception('Nodo No Admitido o No Habilitado');
            }
            if (!$vehicle) {
                throw new \Exception('Vehiculo No Admitido');
            }
            $vehicle->deliveryType()->attach($deliveryType);
            //return new VehicleDeliveryTypesResource($vehicle);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $vehicleId
     * @return mixed
     */
    public function showDriverOfVehicle($vehicleId)
    {
        try {
            //TODO CREAR VALIDACIONES
            $vehicle = Vehicle::findOrFail($vehicleId);
            return new VehicleDriverResource($vehicle);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function uploadVehicleImages($vehiclePictures, $vehicle)
    {
        if ($vehiclePictures) {
            $path = $vehicle->path . '/' . $vehicle->vehicleId;
            foreach ($vehiclePictures as $image) {
                $fileName = ImageManager::uploadBase64Image($image, $path);
                $vehiclePicture = VehiclePicture::create([
                    'relVehicleId' => $vehicle->vehicleId,
                    'vehiclePicture' => $fileName
                ]);

                $vehicle->vehiclePicture()->save($vehiclePicture);
            }
        }
    }

    public function dropVehiclePicture($vehicleId, $vehiclePictureId)
    {
        try {
            $vehicle = Vehicle::findOrFail($vehicleId);
            $vehiclePicture = VehiclePicture::findOrFail($vehiclePictureId);

            File::delete($vehiclePicture->vehiclePicture);
            $vehiclePicture::where('relVehicleId', $vehicleId)->where('id', $vehiclePictureId)
                ->delete();

            return new VehicleResource($vehicle);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'data' => $e->getMessage()
            ]);
        }
    }

}
