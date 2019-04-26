<?php

use Faker\Generator as Faker;

$factory->define(App\City::class, function (Faker $faker) {
    return [
        'name' => strtolower($faker->city),
        'type' => 'miasto',
        'parent' => strtolower($faker->city),
        'lat' => $faker->latitude,
        'lon' => $faker->longitude,
        'importance' => $faker->randomDigit,
        'suggested' => $faker->boolean,
        'community' => $faker->country,
        'county' => $faker->country,
        'state' => $faker->country,
        'west' => $faker->latitude,
        'south' => $faker->latitude,
        'east' => $faker->latitude,
        'north' => $faker->latitude,
    ];
});
