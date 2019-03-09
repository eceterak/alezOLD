<?php

use Faker\Generator as Faker;

$factory->define(App\Advert::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'city_id' => function() {
            return factory(App\City::class)->create()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'rent' => $faker->numberBetween(300, 1000)
    ];
});
