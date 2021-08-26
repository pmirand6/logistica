<?php


namespace App\Resources\RoadMap;


use App\Models\Order\Order;
use App\Models\Shipping\Shipping;
use App\Resources\Order\OrderCollection;
use App\Resources\Order\OrderResource;
use Illuminate\Http\Resources\Json\JsonResource;


class RoadMapMailCollection extends JsonResource
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
            'road_map_code' => $this->road_map_code,
            'orders' => OrderResource::collection($this->orders),
        ];
    }

}
