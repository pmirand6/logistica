<?php
/**
 * Class OrderRepository
 * @package App\Repositories\Order
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 30/11/20 14:57
 */

namespace App\Repositories\Order;

use App\Helpers\DateFilter;
use App\Mail\NotifyProvider;
use App\Models\Order\Order;
use App\Models\Shipping\Shipping;
use App\Models\User\User;
use App\Repositories\RoadMap\RoadMapRepository;
use App\Resources\Order\OrderResource;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;
use App\State\AssignedShippingState;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderRepository implements OrderRepositoryInterface
{

    /**
     * @return mixed
     */
    public function index()
    {
        return OrderResource::collection(Order::paginate());
    }

    /**
     * @param $orderCode
     * @return mixed
     */
    public function show($orderCode)
    {
        try {
            return new OrderResource(Order::where('orderCode', $orderCode)->firstOrFail());
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        try {
            $data = [];

            $requestShipping = json_decode($request->instance()->getContent());
            foreach ($requestShipping as $shippingItem) {

                $shipping = Shipping::where('shippingId', $shippingItem->shipping_id)
                    ->where('pickingOrderCode', '=', NULL)->first();
                if (!$shipping) {
                    $errorArray = [
                        "error" => true,
                        "message" => "Shipping {$shippingItem->shipping_id} no encontrado o asociado a un picking Order"];
                    array_push($data, $errorArray);
                    continue;
                }

                //TODO order->status con el manager de estados
                $order = Order::create([
                    'deliveryType' => $shipping->deliveryType,
                    'relShipping' => $shippingItem->shipping_id,
                    'relVehicle' => $shippingItem->vehicle_id,
                    'relDriver' => $shippingItem->driver_id,
                    'relUser' => User::where('email', $request->input('userAuth0')->email)->first()->id,
                    'status' => config('delivery_order_states.FIRST_STATE.NAME'),
                    'statusCode' => config('delivery_order_states.FIRST_STATE.CODE')
                ]);
                $data[] = $order;

                event(new OrderCreated($request, $order));


                Mail::to($order->shipping->providerEmail)->send(new NotifyProvider($order));
            }

            $roadMap = new RoadMapRepository();
            $roadMap->store($request);
            return response()->json(['data' => $data]);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateOrder($request, $orderCode)
    {
        try {
            // TODO order->status
            $order = Order::where('orderCode', $orderCode)->firstOrFail();
            $order->update([
                'updated_at' => Carbon::now()->toDateTimeString(),
                'status' => "updated"
            ]);

            event(new OrderUpdated($request, $order));

            return response()->json([
                'error' => false,
                'data' => new OrderResource($order),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => '',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => '',
            ], 500);
        }

    }

    public function getOrdersByDriver($driverId, $date)
    {
        try {
            $dateFilter = DateFilter::getFilterDate($date);

            $orders = Order::where('relDriver', $driverId);
            if ($dateFilter) {
                $orders = $orders->whereDate('created_at', $dateFilter);

            }
            $orders = $orders->orderBy('created_at', 'asc');
            $orders = $orders->get();

            //FIXME revisar que la direccion de entrega del shipping sea la adecuada segun el deliveryType
            return response()->json([
                'error' => false,
                'data' => OrderResource::collection($orders),
            ], 200);

        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }
}
