<?php

namespace App\Listeners;

use App\Events\RoadmapCreated;
use App\Models\Order\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ChangeOrderRoadmapCodeWhenCreatingRoadmap
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
     * @param  RoadmapCreated  $event
     * @return void
     */
    public function handle(RoadmapCreated $event)
    {
        try {
            $order = Order::where('orderId', $event->roadmap->rel_picking_order)
                ->where('roadMapCode', NULL)
                ->firstOrFail();

            $order->roadMapCode = $event->roadmap->road_map_code;
            $order->save();

        } catch (\Exception $e) {
            Log::error('error ChangeOrderRoadmapCodeWhenCreatingRoadmap Listener', [
                'error' => $e->getMessage(),
                'date' => Carbon::now()
            ]);
        }
    }
}
