<?php

namespace tests\Setup;

use Illuminate\Support\Facades\Hash;
use Facades\Tests\Setup\AdvertFactory;
use App\User;
use App\Street;
use App\Advert;

class WorldFactory 
{

    /**
     * Create whole application wolrd for testing.
     */
    public static function create()
    {        
        $streets = create(Street::class, [], 20);

        $streets->each(function($street) {
            AdvertFactory::street($street)->create([], 10);
        });
        
        create(User::class, [
            'name' => 'marek',
            'email' => 'bartula.marek@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('marro2'),
            'remember_token' => '',
            'role' => 1
        ]);
    }

}