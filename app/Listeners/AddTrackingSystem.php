<?php

namespace App\Listeners;

use App\Events\ShippingUpdatedBySystem;
use App\Models\Tracking\Tracking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AddTrackingSystem
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
        try {
            Tracking::create([
                'shippingId' => $event->shipping->shippingCode,
                'status' => $event->shipping->status,
            ]);
        } catch (\Exception $e) {
            Log::error('error AddTracking Listener', [
                'error' => $e->getMessage(),
                'date' => Carbon::now()
            ]);
        }
    }
}
