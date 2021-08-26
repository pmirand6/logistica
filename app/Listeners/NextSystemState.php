<?php

namespace App\Listeners;

use App\Events\ShippingUpdated;
use App\Events\ShippingUpdatedBySystem;
use App\Models\Shipping\Shipping;
use App\State\getNextStatesByDeliveryType;
use App\State\hasNextSystemState;
use App\State\ShippingStateManager;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NextSystemState
{
    use hasNextSystemState;

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
     * @param ShippingUpdated $event
     * @return void
     */
    public function handle(ShippingUpdated $event)
    {
        $hasToBeTransitioned = $this->getNextStatesByDeliveryType($event->shipping->deliveryType, $event->shipping->statusCode);

        if ($hasToBeTransitioned) {
            Log::info(json_encode([
                'method' => __METHOD__,
                'has_next_system_state' => $this->getNextStatesByDeliveryType($event->shipping->deliveryType, $event->shipping->statusCode),
                'next_code' => $this->systemStateCode,
                'next_code_name' => $this->systemStateName
            ]));

            $shipping = Shipping::where('shippingCode', $event->shipping->shippingCode)->first();

            $shipping->status = $this->systemStateName;
            $shipping->statusCode = $this->systemStateCode;
            $shipping->save();


            event(new ShippingUpdatedBySystem($shipping));
        }


    }
}
