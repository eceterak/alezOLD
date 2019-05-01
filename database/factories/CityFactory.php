<?php

use Faker\Generator as Faker;

$factory->define(App\City::class, function (Faker $faker) {
    return [
        'name' => $name = strtolower($faker->city),
        'type' => 'miasto',
        'slug' => str_slug($name),
        'parent' => strtolower($faker->city),
        'lat' => $faker->latitude,
        'lon' => $faker->longitude,
        'importance' => $faker->randomDigit,
        'community' => $faker->country,
        'county' => $faker->country,
        'state' => $faker->country,
        'west' => $faker->latitude,
        'south' => $faker->latitude,
        'east' => $faker->latitude,
        'north' => $faker->latitude,
    ];
});
