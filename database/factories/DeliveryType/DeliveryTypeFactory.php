<?php

/** @var Factory $factory */

use App\Models\DeliveryType\DeliveryType;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(DeliveryType::class, function (Faker $faker) {
    return [
        'deliveryTypeId' => $this->faker->uuid,
        'name' => $this->faker->randomElement(['delivery', 'node']),
    ];
});
