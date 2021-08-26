<?php

use App\Models\DeliveryType\DeliveryType;
use App\Models\DeliveryTypeVehicle;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Seeder;

class DeliveryTypeVehicleSeeder extends Seeder
{
    public function run()
    {
        DeliveryTypeVehicle::truncate();

        $delivery_types = DeliveryType::all();
        $vehicles = Vehicle::all();
        foreach ($vehicles as $v) {
            foreach ($delivery_types as $d) {
                $v->deliveryType()->attach($d);
            }
        }
    }
}
