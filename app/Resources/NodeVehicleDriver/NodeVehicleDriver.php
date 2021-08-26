<?php


namespace App\Resources\NodeVehicleDriver;
use App\Resources\Vehicle\VehicleResource;
use Illuminate\Http\Resources\Json\JsonResource;


class NodeVehicleDriver extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'vehicle' => $this->vehicle()->get(),
        ];
    }

}
