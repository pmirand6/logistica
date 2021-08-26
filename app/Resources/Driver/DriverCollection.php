<?php
/**
 * Class DriverCollection
 * @package App\Resources\Driver
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 30/11/20 21:39
 */

namespace App\Resources\Driver;


use App\Resources\Vehicle\VehicleCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverCollection extends JsonResource
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
            'active' => $this->active
            //'vehicle' => VehicleCollection::collection($this->vehicle),
        ];
        //return parent::toArray($request);
    }

}
