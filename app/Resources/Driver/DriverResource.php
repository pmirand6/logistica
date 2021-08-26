<?php


namespace App\Resources\Driver;

use App\Resources\Vehicle\VehicleCollection;
use App\Resources\Vehicle\VehicleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class DriverResource extends JsonResource
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
            'dni' => $this->identityDocument,
            'last_name' => $this->lastName,
            'first_name' => $this->name,
            'e_mail' => $this->email,
            'formatted_address' => $this->formatted_address,
            'area_code' => $this->areaCode,
            'phone_number' => $this->phone,
            'driver_picture' => $this->driverPicture,
            'status' => $this->status,
            'postal_code' => $this->postalCode,
            'address' => $this->address,
            'provinceId' => $this->provinceId,
            'countryId' => $this->countryId,
            'active' => $this->active,
            'vehicle' => VehicleCollection::collection($this->vehicle),
            'user' => $this->user
        ];
        //return parent::toArray($request);
    }
}
