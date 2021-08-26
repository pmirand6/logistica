<?php


namespace App\Resources\PurchaseOrder;


use App\Resources\Shipping\ShippingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderCollection extends JsonResource
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
            'purchase_code' => $this->code,
            'shipping' => ShippingResource::collection($this->shippings)
        ];
    }
}
