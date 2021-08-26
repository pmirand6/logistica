<?php

/** @var Factory $factory */

use App\Models\User\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $this->faker->unique()->safeEmail,
        'userType' => $this->faker->randomElement(['Distribuidor', 'Administrador']),
        'name' => $this->faker->Name(),
    ];
});
