<?php

use Faker\Generator as Faker;

$factory->define(App\Room::class, function (Faker $faker) {
    /* return [
        'stage' => 1,
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'validated' => $faker->boolean(),
        'active' => $faker->boolean(),
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'address' => $faker->streetAddress,
        'property_size' => rand(2, 10),
        'property_type' => rand(1, 5),
        'landlord' => rand(1, 5),
        'living_room' => $faker->boolean(),
        'room_size' => $faker->randomElement(['jednoosobowy', 'dwuosobowy']),
        'furnished' => $faker->boolean(),
        'ensuite' => $faker->boolean(),
        'rent' => $faker->numberBetween(300, 1000),
        'deposit' => $faker->numberBetween(300, 1000),
        'bills_included' => $faker->boolean(),
        'broadband' => $faker->boolean(),
        'available_from' => $faker->dateTime(),
        'minimum_stay' => 0,
        'maximum_stay' => 0,
        'short_term' => $faker->boolean(),
        'days_available' => $faker->randomElement(['7 dni w tygodniu', 'Pon - pia', 'Weekendy']),
        'smooking' => $faker->boolean(),
        'gender' => $faker->randomElement(['N', 'K', 'M']),
        'occupation' => $faker->randomElement(['N', 'S', 'P']),
        'pets' => $faker->boolean(),
        'minimum_age' => $faker->numberBetween(18, 99),
        'maximum_age' => $faker->numberBetween(18, 99),
        'couples' => $faker->boolean()
    ]; */

    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'address' => $faker->streetAddress        
    ];
});