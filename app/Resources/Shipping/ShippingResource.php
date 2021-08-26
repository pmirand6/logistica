<?php

namespace App\Resources\Shipping;

use App\Manager\DateManager;
use App\Models\Node\Node;
use App\Resources\Order\OrderResource;
use App\State\ShippingStateManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ShippingResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     * @param $request
     * @return array
     */

    public function toArray($request)
    {
//  TODO FILTRAR PARA QUE NO BUSQUÉ LOS SHIPPINGS DEL TIPO TAKE-AWAY
        return [
            'id' => $this->shippingId,
            'shipping_code' => $this->shippingCode,
            'estimated_deliveryDate' => $this->estimatedDeliveryDate,
            'picking_orderCode' => $this->pickingOrderCode,
            'product' => $this->product,
            'product_price' => $this->product_price,
            'product_description' => $this->productDescription,
            'product_id' => $this->product_id,
            'product_image' => $this->productImageUrl,
            'quantity' => $this->quantity,
            'client_name' => $this->clientName,
            'client_email' => $this->client_email,
            'client_phone_number' => $this->client_phone_number,
            'client_identification_number' => $this->client_identification_number,
            'driver_name' => $this->pickOrder->driver->full_name ?? null,
            'vehicle_license_plate' => $this->pickOrder->vehicle->licensePlate ?? null,
            'requires_cold' => $this->requiresCold,
            'drop_address' => ($this->deliveryType == 'delivery' || $this->deliveryType == 'takeaway') ? $this->customerDeliveryAddress : $this->node()->get(['streetName', 'businessName'])->toArray(),
            'delivery_type' => $this->deliveryType,
            'qrCode' => $this->qrCode,
            'provider_address' => $this->providerAddress,
            'provider_email' => $this->providerEmail,
            'provider_name' => $this->providerName,
            'node_id' => $this->node_id,
            'node_name' => $this->node->name,
            'status' => $this->status,
            'status_code' => $this->statusCode,
            'next_status' => $this->getNextStates($this->statusCode, $this->deliveryType, $request),
            'vehicles' => $this->when($this->checkRol($request), function () {
                return $this->pickOrder ? null : $this->getDistributorsFromNode($this->node_id, $this->deliveryType);
            }),
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }

    public function getDistributorsFromNode($nodeId, $deliveryType)
    {
        try {
            $vehicle = (new Node)->where('nodeId', $nodeId)
                ->with(['vehicle' => function ($q) use ($deliveryType) {
                    $q->whereHas('deliveryType', function ($d) use ($deliveryType) {
                        $d->where('name', $deliveryType);
                    })
                        ->with(['driver' => function ($v) {
                            $v->where('active', true)
                                ->select('driverId', 'lastName', 'name', 'active');
                        }])
                        ->where('deliveryDays', 'like', '%' . (new DateManager())->getTodayName() . '%')
                        ->where('active', true);
                }])
                ->firstOrFail();

            return $vehicle['vehicle'];


        } catch (ModelNotFoundException $e) {
            Log::error(json_encode([
                'method' => __METHOD__,
                'error' => $e->getMessage()
            ]));
        }

    }

    private function getNextStates($shippingStatusCode, $deliveryType, $request): array
    {
        try {
            return ShippingStateManager::getNextState($shippingStatusCode, $deliveryType, $request);
        } catch (\Exception $e) {
            Log::error(json_encode([
                'method' => __METHOD__,
                'error' => $e->getMessage()
            ]));
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function checkRol(Request $request): bool
    {
        return in_array('role:admin', $request->permissions);
    }

}
