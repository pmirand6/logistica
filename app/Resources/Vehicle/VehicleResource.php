<?php


namespace App\Resources\Vehicle;

use App\Resources\VehiclePicture\VehiclePictureCollection;
use App\Resources\Driver\DriverCollection;
use App\Resources\Driver\DriverResource;
use App\Resources\Node\NodeResource;
use App\Resources\DeliveryType\DeliveryTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->vehicleId,
            'brand' => $this->brand,
            'model' => $this->model,
            'license_plate' => $this->licensePlate,
            'year' => $this->year,
            'active' => $this->active,
            'start_work' => $this->workHourStart,
            'end_work' => $this->workHourEnd,
            'extern' => $this->extern,
            'delivery_days' => $this->deliveryDays,
            'vehicle_pictures' => $this->vehiclePicture,
            'delivery_types' => $this->deliveryType()->pluck('name'),
            'drivers' => DriverCollection::collection($this->driver),
            'nodes' => NodeResource::collection($this->node)
        ];
    }

}
