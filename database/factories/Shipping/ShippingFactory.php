<?php

/** @var Factory $factory */

use App\Models\Node\Node;
use App\Models\Shipping\Shipping;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Shipping::class, function (Faker $faker) {
    $status = $this->faker->randomElement($array = array('Confirmado', 'Empacado'));
    $statusCode = $status == 'Confirmado' ? 'PRODUCT_ORDER_CONFIRMED' : 'PACKED';
    return [
        'shippingId' => $this->faker->uuid,
        'node_id' => Node::all()->first(),
        'status' => $status,
        'statusCode' => $statusCode,
        'orderDate' => $faker->dateTimeBetween('now', '+01 days'),
        'product' => $this->faker->word,
        'productDescription' => $this->faker->text,
        'quantity' => $this->faker->randomNumber,
        'estimatedDeliveryDate' => $faker->dateTimeBetween('now', '+01 days'),
        'clientName' => $this->faker->name,
        'qrCode' => $this->faker->imageUrl(),
        'requiresCold' => (bool)random_int(0, 1),
        'deliveryType' => $this->faker->randomElement($array = array('delivery', 'node', 'takeaway')),
        'providerAddress' => $this->faker->streetName . ' ' . $this->faker->numerify('####'),
        'customerDeliveryAddress' => $this->faker->streetName . ' ' . $this->faker->numerify('####'),
        'productImageUrl' => $this->faker->imageUrl(),
        'providerEmail' => $this->faker->unique()->safeEmail,
        'providerName' => $this->faker->name,
    ];
});
