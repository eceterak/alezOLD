<?php

use Faker\Generator as Faker;
use App\Message;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph
    ];
});
