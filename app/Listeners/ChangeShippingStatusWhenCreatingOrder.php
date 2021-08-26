<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Events\ShippingUpdated;
use App\Models\Shipping\Shipping;
use App\State\ShippingStateManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ChangeShippingStatusWhenCreatingOrder
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
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        try {
            $shipping = Shipping::where('shippingId', $event->order->relShipping)
            ->where('pickingOrderCode', NULL)
            ->firstOrFail();

            $shipping->update([
                'status' => $event->order->status, //TODO indicar status real con manager de estados
                'statusCode' => $event->order->statusCode,
                'pickingOrderCode' => $event->order->orderCode
            ]);

            event(new ShippingUpdated($shipping, $event->request));
        } catch (\Exception $e) {
            Log::error('error AddShippingUpdated Listener', [
                'error' => $e->getMessage(),
                'date' => Carbon::now()
            ]);
        }
    }
}
