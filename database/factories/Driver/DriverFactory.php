<?php

/** @var Factory $factory */

use App\Models\Driver\Driver;
use App\Models\User\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Driver::class, function (Faker $faker) {
    return [
        'driverId' => $this->faker->uuid,
        'identityDocument' => $this->faker->bankAccountNumber,
        'lastName' => $this->faker->lastName,
        'name' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'user_id' => factory(User::class)->create()->id,
        'areaCode' => $this->faker->numerify('####'),
        'phone' => $this->faker->phoneNumber,
        'driverPicture' => $this->faker->imageUrl(),
        'active' => $this->faker->boolean(),
        'postalCode' => $this->faker->postcode,
        'address' => $this->faker->streetName,
        'provinceId' => $this->faker->numerify('#'),
        'countryId' => $this->faker->numerify('#'),
        'formatted_address' => $this->faker->streetName,
    ];
});
