<?php
/**
 * Class OrderCollection
 * @package App\Resources\Order
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 2/12/20 13:23
 */

namespace App\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderCollection extends JsonResource
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
            'order_id' => $this->orderId,
            'order_code' => $this->orderCode,
            'created_at' => $this->created_at,
        ];
    }
}
