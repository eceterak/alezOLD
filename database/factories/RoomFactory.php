<?php

use Faker\Generator as Faker;

$factory->define(App\Room::class, function (Faker $faker) {
    /* return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        
        'property_size' => rand(2, 10),
        'property_type' => rand(1, 5),
        'landlord' => rand(1, 5),
        'living_room' => $faker->boolean(),
        'room_size' => $faker->randomElement(['jednoosobowy', 'dwuosobowy']),
        'furnished' => $faker->boolean(),
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
        // General info
        'title' => $faker->sentence,
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

        // Room details
        'room_size' => $faker->randomElement(['single', 'double', 'triple']),
        'furnished' => $faker->boolean(),
        'broadband' => $faker->boolean(),

        // Desired tenetant.
        'smooking' => $faker->boolean(),
        'pets' => $faker->boolean(),
        'occupation' => $faker->randomElement(['n', 'student', 'professional']),
        'couples' => $faker->boolean(),
        'gender' => $faker->randomElement(['n', 'm', 'f']),
        'minimum_age' => $faker->numberBetween(16, 80),
        'maximum_age' => $faker->numberBetween(16, 80)
    ];
});