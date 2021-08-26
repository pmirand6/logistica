<?php

namespace App\Listeners;

use App\Events\ShippingUpdated;
use App\Models\Tracking\Tracking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AddTrackingUpdated
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
    public function handle(ShippingUpdated $event)
    {
        Log::alert('AddTracking Listener', [
            'email' => $event->request->userAuth0->email
        ]);

        try {
            Tracking::create([
                'shippingId' => $event->shipping->shippingCode,
                'status' => $event->shipping->statusCode,
                'email_action' => $event->request->userAuth0->email
            ]);
        } catch (\Exception $e) {
            Log::error('error AddTracking Listener', [
                'error' => $e->getMessage(),
                'date' => Carbon::now()
            ]);
        }
    }
}
