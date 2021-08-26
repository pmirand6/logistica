<?php


namespace App\Repositories\Shipping;


use App\Events\ShippingCreated;
use App\Events\ShippingUpdated;
use App\Manager\ArrayManager;
use App\Models\Node\Node;
use App\Models\PurchaseOrder\PurchaseOrder;
use App\Models\Shipping\Shipping;
use App\Resources\PurchaseOrder\PurchaseOrderCollection;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\PurchaseOrder\PurchaseOrderRepository;
use App\Resources\Shipping\ShippingResource;
use App\State\ShippingStateManager;
use Carbon\CarbonTimeZone;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ShippingRepository implements ShippingRepositoryInterface
{

    public function showAllShippings($request)
    {
        try {
            $date = $this->getFilterDate($request);
            $shipping = new Shipping();

            if ((!$request->has('all')) && (!$request->has('status'))) {
                $shipping = $shipping->withFirstState();
            }

            if ($date) {
                $shipping = $shipping->whereDate('estimatedDeliveryDate', $date);
            }

            if ($request->has('requiresCold')) {
                $shipping = $shipping->withRequiresCold($request->requiresCold);
            }

            if ($request->has('deliveryOrder')) {
                $shipping = $shipping->withDeliveryOrder($request->deliveryOrder);
            }

            if ($request->has('status')) {
                $shipping = $shipping->withStatus($request->status);
            }

            if ($request->has('node')) {
                $shipping = $shipping->withNode($request->node);
            }

            if ($request->has('shippingCode')) {
                $shipping = $shipping->withShippingCode($request->shippingCode);
            }

            if (!$request->has('node')) {
                $shipping = $shipping->withAllDeliveryTypes();
            }

            $shipping = $shipping->orderBy('estimatedDeliveryDate', 'asc');
            $shipping = $shipping->paginate(10);

            return ShippingResource::collection($shipping);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => '',
                ''
            ], 500);
        }
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function getShippingsByProviderEmail($request)
    {
        try {
            $date = $this->getFilterDate($request);
            $userAuth0 = $request->instance()->query('userAuth0') == null ? $request->userAuth0 : $request->instance()->query('userAuth0');
            $callback = $this->getProviderClosure($date, $request, $userAuth0);

            /**
             * Se obtienen los shippings relacionados con el purchase Order
             */
            $purchaseOrders = PurchaseOrder::query()
                ->orWhereHas('shippings', $callback)
                ->with(['shippings' => $callback])
                ->paginate(10);


//            $purchaseOrders->whereHas('shippings', $callback)
//                ->with(['shippings' => $callback]);

            /**
             * Se retorna la coleccion de Purchase con los shippings relacionados
             */

            return PurchaseOrderCollection::collection($purchaseOrders);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => '',
            ], 500);
        }
    }

    private function getFilterDate($request)
    {
        if ($request->date) {
            switch ($request->date) {
                case 'today':
                    $date = Carbon::now()->format('Y-m-d');
                    break;

                case 'tomorrow':
                    $date = new Carbon('tomorrow');
                    $date = $date->format('Y-m-d');
                    break;

                case 'after_tomorrow':
                    $date = Carbon::now()->addDays(2)->format('Y-m-d');
                    break;

                default:
                    $date = "";
                    break;
            }
            return $date;
        }

        return false;
    }

    public function showShippingByCode($shippingCode)
    {
        try {
            $shipping = Shipping::where('shippingCode', $shippingCode)->firstOrFail();

            return response()->json([
                'error' => false,
                'data' => new ShippingResource($shipping),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => '',
            ]);
        }
    }

    public function updateShipping($request, $shippingCode): JsonResponse
    {
        try {
            if ($request->has('status')) {

                $shipping = Shipping::where('shippingCode', $shippingCode);
                if (in_array('role:provider', $request->permissions)) {
                    $shipping = $shipping->where('providerEmail', $request->userAuth0->email);
                }
                $shipping = $shipping->firstOrFail();


                $shippingStatus = ShippingStateManager::checkUpdateShipping($request->status, $shipping->statusCode, $shipping->deliveryType, $request);

                if (!$shippingStatus) {
                    throw new \Exception("Error en la asignación del estado {$request->status}");
                }

                $statusName = ShippingStateManager::shippingState($shipping->deliveryType, $request->status);

                $shipping->status = $statusName;
                $shipping->statusCode = $request->status;
                $shipping->save();
                event(new ShippingUpdated($shipping, $request));

                $shipping = Shipping::where('shippingCode', $shippingCode)->firstOrFail();

                return response()->json([
                    'error' => false,
                    'data' => new ShippingResource($shipping),

                ], 200);
            }

        } catch (ModelNotFoundException $e) {
            Log::error(json_encode([
                'error' => __METHOD__ . " Error en update del shipping {$shippingCode}",
                'message' => $e->getMessage(),
            ]));
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => '',
                'method' => __METHOD__
            ], 404);

        } catch (\Exception $e) {
            Log::error(json_encode([
                'error' => __METHOD__ . " Error en update del shipping {$shippingCode}",
                'message' => $e->getMessage(),
            ]));
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => '',
                'method' => __METHOD__
            ], 403);
        }

    }

    public function createShipping($request)
    {
        try {

            $shippingStatus = ShippingStateManager::shippingState($request->deliveryType, $request->status);
            $nodeId = $request->node_id ? $request->node_id : Node::first()->nodeId;

            if (!$shippingStatus) {
                throw new \Exception('El estado inicial de un shipping debe ser ' . config('shipping_states.0.NAME'));
            }

            if (!$purchaseOrder = PurchaseOrder::where('code', $request->purchaseOrder)->first()) {
                $purchaseOrder = new PurchaseOrderRepository();
                $purchaseOrder = $purchaseOrder->store($request->purchaseOrder);
            }

            $shipping = Shipping::create([
                'node_id' => $nodeId,
                'purchase_order_id' => $purchaseOrder->id,
                'providerAddress' => $request->providerAddress,
                'status' => $shippingStatus,
                'statusCode' => $request->status,
                'orderDate' => $request->orderDate,
                'product' => $request->product,
                'product_price' => $request->product_price,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'clientName' => $request->clientName,
                'client_email' => $request->client_email,
                'client_phone_number' => $request->client_phone_number,
                'client_identification_number' => $request->client_identification_number,
                'estimatedDeliveryDate' => $request->estimated_delivery_date,
                'deliveryType' => $request->deliveryType,
                'productImageUrl' => $request->productImageUrl,
                'requiresCold' => $request->requires_cold,
                'qrCode' => $request->qrCode,
                'customerDeliveryAddress' => $request->customer_delivery_address,
                'providerEmail' => $request->provider_email,
                'providerName' => $request->provider_name,
                'productDescription' => $request->product_description
            ]);
            event(new ShippingCreated($shipping, $request));
            return response()->json([
                'error' => false,
                'data' => new ShippingResource($shipping),
            ], 201);
        } catch (\Exception $e) {
            Log::error(json_encode([
                'method' => __METHOD__,
                'error' => $e->getMessage()
            ]));
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getShippingsByNode($nodeId)
    {
        try {
            //TODO CREAR VALIDACIONES
            $shippings = Shipping::withNode($nodeId)->paginate(10);
            return response()->json([
                'error' => false,
                'data' => ShippingResource::collection($shippings)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'data' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getStates($request)
    {
        $state = collect(config('shipping_states'));

        if ($request->has('order')) {
            $state = $state->sortBy($request->order)->values()->all();
        }

        $listStatesByPermission = [];

        foreach ($state as $item) {
            foreach ($item["ROL"] as $rol) {
                if (in_array($rol, $request->permissions)) {
                    array_push($listStatesByPermission, $item);
                }
            }
        }

        ArrayManager::array_sort_by($listStatesByPermission, 'NAME', $order = SORT_ASC);

        try {
            return response()->json([
                'error' => false,
                'data' => $listStatesByPermission
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'data' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param bool $date
     * @param $request
     * @param $userAuth0
     * @return \Closure
     */
    private function getProviderClosure(bool $date, $request, $userAuth0): \Closure
    {
        $callback = function ($query) use ($date, $request, $userAuth0) {
            $query->where('providerEmail', $userAuth0->email);

            if (!($request->has('all')) && !($request->has('status'))) {
                $query->withProviderFirstState();
            }

            if ($date) {
                $query->whereDate('estimatedDeliveryDate', $date);
            }

            if ($request->has('requiresCold')) {
                $query->withRequiresCold($request->requiresCold);
            }

            if ($request->has('deliveryOrder')) {
                $query->withDeliveryOrder($request->deliveryOrder);
            }

            if ($request->has('status')) {
                $query->withStatus($request->status);
            }

            if ($request->has('node')) {
                $query->withNode($request->node);
            }

            if ($request->has('shippingCode')) {
                $query->withShippingCode($request->shippingCode);
            }
        };
        return $callback;
    }

}
