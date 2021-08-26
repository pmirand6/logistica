<?php

namespace App\Listeners;

use App\Events\ShippingUpdatedBySystem;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Log;

class OrderChangeStatusSystem
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ShippingUpdatedBySystem  $event
     * @return void
     */
    public function handle(ShippingUpdatedBySystem $event)
    {
        //FIXME Esta funcion debería estar en un trait
        $hasToUpdate = (config('shipping_states.0.CODE') != $event->shipping->statusCode) === (config('shipping_states.1.CODE') != $event->shipping->statusCode);

        if($hasToUpdate){
            try{
                $order = Order::where('relShipping', $event->shipping->shippingId)->firstOrFail();
                $order->status = $event->shipping->status;
                $order->save();
                Log::info("Order {$order->orderCode} fue actualizada al estado {$event->shipping->status}");
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }
}
