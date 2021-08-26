<?php
/**
 * Class RoadMapCollection
 * @package App\Resources\RoadMap
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 2/12/20 13:14
 */

namespace App\Resources\RoadMap;


use App\Resources\Order\OrderCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class RoadMapCollection extends JsonResource
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
            'road_map_id' => $this->orderId,
            'road_map_code' => $this->orderCode,
            'orders' => OrderCollection::collection($this->orders),
        ];
    }

}
