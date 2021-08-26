<?php

/** @var Factory $factory */

use App\Models\Node\Node;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Node::class, function (Faker $faker) {
    return [
        'nodeId' => $this->faker->uuid,
        'name' => "Feriame Point",
        'businessName' => "Feriame Point",
        'geo' => $this->faker->postcode,
        'latitude' => "-38.923550",
        'longitude' => "-68.014995",
        'streetName' => "RN 151 Km 2, Cipolletti, Río Negro",
        'floor' => $this->faker->randomNumber,
        'departmentNumber' => $this->faker->numerify('#'),
        'logo' => $this->faker->imageUrl(),
        'phoneNumber' => $this->faker->phoneNumber,
        'email' => $this->faker->safeEmail,
        'localitiesId' => $this->faker->numerify('#'),
        'active' => '1',
    ];
});
