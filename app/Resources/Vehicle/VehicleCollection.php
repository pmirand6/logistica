<?php
/**
 * Class VechicleCollection
 * @package App\Resources\Vehicle
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 30/11/20 20:56
 */

namespace App\Resources\Vehicle;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\DeliveryType\DeliveryTypeResource;

class VehicleCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
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
        ];
    }
}
