<?php

use Faker\Generator as Faker;

$factory->define(App\Room::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class),
        'city_id' => factory(App\City::class),
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'rent' => $faker->numberBetween(300, 1000)
    ];
});
