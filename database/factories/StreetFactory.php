<?php

use Faker\Generator as Faker;

$factory->define(App\Street::class, function (Faker $faker) {
    return [
        'name' => strtolower($faker->city),
        'lat' => $faker->latitude,
        'lon' => $faker->longitude
    ];
});
