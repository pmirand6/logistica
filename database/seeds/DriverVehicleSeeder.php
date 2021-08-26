<?php
use App\Models\Driver\Driver;
use App\Models\DriverVehicle;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Seeder;

class DriverVehicleSeeder extends Seeder
{
    public function run()
    {
        // Get all the roles attaching up to 3 random roles to each user
        DriverVehicle::truncate();

        $drivers = Driver::all();
        $vehicles = Vehicle::all();

        foreach ($drivers as $d) {
            foreach ($vehicles as $v) {
                $v->driver()->attach($d);
            }
        }
    }
}
