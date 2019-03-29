<?php

use Faker\Generator as Faker;

$factory->define(App\City::class, function (Faker $faker) {
    return [
        'name' => strtolower($faker->city),
        'suggested' => $faker->boolean()
    ];
});
