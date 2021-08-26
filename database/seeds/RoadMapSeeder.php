<?php

use App\Models\Order\Order;
use App\Models\RoadMap\RoadMap;
use Illuminate\Database\Seeder;

class RoadMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoadMap::create([
            'rel_picking_order' => Order::all()->first()->orderId,
        ]);
    }
}
