<?php

/** @var Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Order\Order::class, function (Faker $faker) {
    return [
        /*'orderId' =>,
        'relShipping'=>,
        'relVehicle' =>,
        'relDriver'=>,
        'relUser'=>,*/
    ];
});
