<?php

/** @var Factory $factory */
use App\Models\Vehicle\Vehicle;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Vehicle::class, function (Faker $faker) {

    return [
        'vehicleId' => $this->faker->uuid,
        'brand' => $this->faker->randomElement(['FORD', 'FIAT', 'CHEVROLET']),
        'model' => $this->faker->randomElement(['Fiorino', 'Kooga', 'Spin']),
        'licensePlate' => $this->faker->bothify('?-?##-#?#'),
        'active' => $this->faker->boolean(),
        'extern' => $this->faker->boolean(),
        'year' => $this->faker->year,
        'workHourStart' => $this->faker->time(),
        'workHourEnd' => $this->faker->time(),
        'deliveryDays' => ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes"]
    ];
});


