<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Tracking\Tracking;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Tracking::class, function (Faker $faker) {
    return [
        'trackingId' => $this->faker->uuid,
        'shippingId' => $this->faker->uuid,
        'status' => $this->faker->randomElement($array = array ('a','b','c','d')),
    ];
});
