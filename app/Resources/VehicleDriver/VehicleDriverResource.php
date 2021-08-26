<?php


namespace App\Resources\VehicleDriver;

use App\Resources\DriverVehicle\DriverVehicleCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleDriverResource extends JsonResource
{
    // protected $driver;

    // public function appendDriver($driver){
    //     $this->driver = $driver;
    //     return $this;
    // }
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request un
     * @return array
     */
    public function toArray($request)
    {
        return [
            'vehicleId' => $this->vehicleId,
            'brand' => $this->brand,
            'model' => $this->model,
            'licensePlate' => $this->licensePlate,
            'extern' => $this->extern,
            'year' => $this->year,
            'vehiclePicture' => $this->vehiclePicture,
            'driver' => DriverVehicleCollection::collection($this->driver)
        ];
    }

    public function show()
    {

    }

}
