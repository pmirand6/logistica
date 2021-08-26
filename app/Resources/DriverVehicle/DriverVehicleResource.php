<?php


namespace App\Resources\DriverVehicle;


use App\Resources\Vehicle\VehicleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverVehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'driverId' => $this->driverId,
            'identityDocument' => $this->identityDocument,
            'lastName' => $this->lastName,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'driverPicture' => $this->driverPicture,
            'status' => $this->status,
            'postalCode' => $this->postalCode,
            'street' => $this->street,
            'streetNumber' => $this->streetNumber,
            'floorAddress' => $this->floorAddress,
            'locality' => $this->locality,
            'provinceId' => $this->provinceId,
            'countryId' => $this->countryId,
            'vehicle' => VehicleResource::collection($this->vehicle),
        ];
        //return parent::toArray($request);
    }
}
