<?php

use Faker\Generator as Faker;

$factory->define(App\Room::class, function (Faker $faker) {
    return [
        'place_id' => $faker->sha1,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'address' => $faker->streetAddress,
        'property_size' => rand(2, 10),
        'property_type_id' => rand(1, 5),
        'user_status' => rand(1, 5),
        'living_room' => $faker->boolean(),
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'rent' => $faker->numberBetween(300, 1000)
    ];
});