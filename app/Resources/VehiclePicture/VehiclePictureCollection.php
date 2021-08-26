<?php
/**
 * Class VehiclePictureCollection
 * @package App\Resources\VehiclePicture
 */

namespace App\Resources\VehiclePicture;

use Illuminate\Http\Resources\Json\JsonResource;

class VehiclePictureCollection extends JsonResource
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
            'id' => $this->id,
            'vehicle_id' => $this->vehicleId,
            'vehicle_picture' => $this->vehiclePicture,
        ];
    }

}
