<?php

use App\Models\Driver\Driver;
use App\Models\Order\Order;
use App\Models\Shipping\Shipping;
use App\Models\User\User;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shipping = Shipping::all()->first();

        Order::create([
            'relShipping' => $shipping->shippingId,
            'relVehicle' => Vehicle::all()->first()->vehicleId,
            'relDriver' => Driver::all()->first()->driverId,
            'relUser' => User::all()->first()->id,
            'deliveryType' => $shipping->deliveryType,
            'status' => "default",
            'statusCode' => 'default'
        ]);
    }
}
