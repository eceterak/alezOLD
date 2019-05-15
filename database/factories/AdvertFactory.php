<?php

use Faker\Generator as Faker;

$factory->define(App\Advert::class, function (Faker $faker) {

    $city = factory('App\City')->create();

    return [
        // General info
        'title' => $faker->text(50),
        'description' => $faker->paragraph,
        'landlord' => $faker->randomElement(['live_in', 'live_out', 'tenetant', 'agent', 'former']),
        
        // Availability.
        'available_from' => $faker->date(),
        'minimum_stay' => $faker->numberBetween(0, 24),
        'maximum_stay' => $faker->numberBetween(0, 24),

        // $$$
        'rent' => $faker->numberBetween(300, 1500),
        'deposit' => $faker->numberBetween(300, 1500),
        'bills' => $faker->numberBetween(100, 300),

        // Property details
        'property_type' => $faker->randomElement(['block', 'house', 'tenement', 'apartment', 'loft']),
        'property_size' => $faker->numberBetween(1, 10),
        'living_room' => $faker->boolean(),

        // Advert details
        'room_size' => $faker->randomElement(['single', 'double', 'triple']),
        'furnished' => $faker->boolean(),
        'broadband' => $faker->boolean(),

        // Desired tenetant.
        'smoking' => $faker->boolean(),
        'pets' => $faker->boolean(),
        'occupation' => $faker->randomElement(['n', 'student', 'professional']),
        'couples' => $faker->boolean(),
        'gender' => $faker->randomElement(['n', 'm', 'f']),
        'minimum_age' => $faker->numberBetween(16, 80),
        'maximum_age' => $faker->numberBetween(16, 80)
    ];
});