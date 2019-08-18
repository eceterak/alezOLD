<?php

use Faker\Generator as Faker;

$factory->define(App\Advert::class, function (Faker $faker) {

    return [
        // General info
        'title' => $faker->text(50),
        'description' => $faker->paragraph,
        'verified' => true,
        'archived' => false,
        'visits' => 0,
        'phone' => 500600700,
        'landlord' => $faker->randomElement(['live_in', 'live_out', 'tenetant', 'agent', 'former']),
        'room_size' => $faker->randomElement(['single', 'double', 'triple']),

        // $$$
        'rent' => $faker->numberBetween(300, 1500),
        'deposit' => $faker->numberBetween(300, 1500),
        'bills' => $faker->numberBetween(100, 300),
        
        // Availability.
        'available_from' => $faker->date,
        'minimum_stay' => 12,
        'maximum_stay' => 24,

        // Property details
        'property_type' => $faker->randomElement(['block', 'house', 'tenement', 'apartment', 'loft']),
        'property_size' => $faker->numberBetween(1, 10),
        
        // Advert details
        'furnished' => $faker->boolean(),
        'broadband' => $faker->boolean(),
        'garage' => $faker->boolean(),
        'garden' => $faker->boolean(),
        'living_room' => $faker->boolean(),
        'parking' => $faker->boolean(),

        // Desired tenetant.
        'pets' => $faker->boolean(),
        'occupation' => $faker->randomElement(['student', 'professional']),
        'nonsmoking' => $faker->boolean(),
        'couples' => $faker->boolean(),
        'gender' => $faker->randomElement(['m', 'f']),
        'minimum_age' => $faker->numberBetween(16, 80),
        'maximum_age' => $faker->numberBetween(16, 80)
    ];
});