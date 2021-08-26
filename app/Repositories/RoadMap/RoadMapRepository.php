<?php
/**
 * Class RoadMapRepository
 * @package App\Repositories\RoadMap
 * Author: Pablo Miranda
 * Project: Feriame - Logistica
 * 2/12/20 13:13
 */

namespace App\Repositories\RoadMap;


use App\Mail\RoadmapGenerated;
use App\Models\Driver\Driver;
use App\Models\Order\Order;
use App\Models\RoadMap\RoadMap;
use App\Resources\RoadMap\RoadMapCollection;
use App\Events\RoadmapCreated;
use App\Mail\ShippingLabels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class RoadMapRepository implements RoadMapInterface
{

    public function index()
    {
        return RoadMapCollection::collection(RoadMap::all());
    }

    public function show()
    {
        // TODO: Implement show() method.
    }

    public function getByDriver()
    {
        // TODO: Implement getByDriver() method.
    }

    public function store($request)
    {
        try {
            $orders = Order::where('roadMapCode', '=', NULL)
                ->orderBy('created_at')->get()->groupBy(function ($item) {
                    return $item->relDriver;
                });

            foreach ($orders as $order) {
                $roadMapCode = RoadMap::withCodeRoadMap();

                foreach ($order as $i) {
                    $roadmap = RoadMap::create([
                        'rel_picking_order' => $i->orderId,
                        'road_map_code' => $roadMapCode,
                        'rel_driver_id' => $i->relDriver
                    ]);

                    event(new RoadmapCreated($roadmap));
                    $driver = Driver::where('driverId', '=', $i->relDriver)->first();
                }

                Log::info(__class__ . " Envío de Mail al Chofer {$driver->email}");
                Mail::to($driver->email)->send(new RoadmapGenerated($roadMapCode));

                Log::info(__class__ . " Envío de Mail al Administrador {$request->input('userAuth0')->email}");
                Mail::to($request->input('userAuth0')->email)->send(new ShippingLabels($roadMapCode));
            }

        } catch (\Exception $e) {
            Log::error(__class__ . ' Error en la Generación de Roadmap: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }

    }

}
