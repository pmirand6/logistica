<?php
/**
 * Class OrderResource
 * @package App\Resources\OrderResource
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 30/11/20 15:19
 */

namespace App\Resources\Order;

use App\Models\Order\Order;
use App\Resources\Shipping\ShippingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'shipping' => $this->shipping()->get(),
            'vehicle' => $this->vehicle()->get(),
            'driver' => $this->driver()->get(),
            'user' => $this->user()->get(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

}
