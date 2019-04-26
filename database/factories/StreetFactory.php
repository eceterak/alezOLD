<?php

use Faker\Generator as Faker;

$factory->define(App\Street::class, function (Faker $faker) {
    return [
        'name' => strtolower($faker->streetName),
        'type' => 'residential',
        'lat' => $faker->latitude,
        'lon' => $faker->longitude,
        'importance' => 0.2,
        //'city' => $faker->city,
        'coordinates' => 'point(50, 20)'
    ];
});
