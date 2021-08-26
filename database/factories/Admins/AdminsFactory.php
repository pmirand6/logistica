<?php

/** @var Factory $factory */

use App\Models\Admins\Admins;
use App\Models\User\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Admins::class, function (Faker $faker) {
    return [
        'active' => $this->faker->randomElement([0, 1]),
        'user_id' => factory(User::class)->create()->id
    ];
});
