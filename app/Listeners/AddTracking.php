<?php

namespace App\Listeners;

use App\Events\ShippingCreated;
use App\Models\Tracking\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddTracking
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param ShippingCreated $event
     * @param Request $request
     * @return void
     */
    public function handle(ShippingCreated $event)
    {
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
