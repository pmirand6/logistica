<?php

use App\Models\DeliveryType\DeliveryType;
use Illuminate\Database\Seeder;

class DeliveryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //factory(DeliveryType::class)->times(2)->create();
       DeliveryType::create([
           //'deliveryTypeId' => $this->faker->uuid,
           'name' => 'delivery',
       ]);

        DeliveryType::create([
            //'deliveryTypeId' => $this->faker->uuid,
            'name' => 'node',
        ]);

    }
}
