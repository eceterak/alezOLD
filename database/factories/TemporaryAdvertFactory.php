<?php

use Faker\Generator as Faker;

$factory->define(App\TemporaryAdvert::class, function (Faker $faker) {
    return [
        'token' => str_random(40)
    ];
});
