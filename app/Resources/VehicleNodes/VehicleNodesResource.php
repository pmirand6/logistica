<?php


namespace App\Resources\VehicleNodes;

use App\Resources\Node\NodeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleNodesResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'vehicleId' => $this->vehicleId,
            'brand' => $this->brand,
            'model' => $this->model,
            'licensePlate' => $this->licensePlate,
            'year' => $this->year,
            'extern' => $this->extern,
            'vehiclePicture' => $this->vehiclePicture,
            'nodes' => NodeResource::collection($this->node),
        ];
    }
}
