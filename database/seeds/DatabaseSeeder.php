<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DriverSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(DriverVehicleSeeder::class);
        $this->call(NodeSeeder::class);
        $this->call(NodeVehicleSeeder::class);
        $this->call(DeliveryTypeSeeder::class);
        $this->call(DeliveryTypeVehicleSeeder::class);
        $this->call(ShippingSeeder::class);
        //$this->call(UserSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(AdminsSeeder::class);
    }
}
