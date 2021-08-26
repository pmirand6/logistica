<?php

namespace App\Listeners;

use App\Events\OrderUpdated;
use App\Events\ShippingUpdated;
use App\Models\Shipping\Shipping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ChangeShippingStatus
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
     * @param  ShippingUpdated  $event
     * @return void
     */
    public function handle(OrderUpdated $event)
    {
        try {
            $shipping = Shipping::where('shippingId', $event->order->relShipping)
            ->where('pickingOrderCode',$event->order->orderCode)
            ->firstOrFail();
            $shipping->update([
                'status' => $event->order->status
            ]);

            event(new ShippingUpdated($shipping));
        } catch (\Exception $e) {
            Log::error('error AddShippingUpdated Listener', [
                'error' => $e->getMessage(),
                'date' => Carbon::now()
            ]);
        }
    }
}
