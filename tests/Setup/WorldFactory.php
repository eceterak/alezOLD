<?php

namespace tests\Setup;

use Illuminate\Support\Facades\Hash;
use Facades\Tests\Setup\RoomFactory;
use Facades\Tests\Setup\StreetFactory;
use App\User;

class WorldFactory 
{

    /**
     * Create whole application wolrd for testing.
     */
    public static function create()
    {
        $street = StreetFactory::create();
        
        for($i = 0; $i < 3; $i++)
        {
            RoomFactory::street($street)->create();
            RoomFactory::create();
        }
        
        factory(User::class)->create([
            'name' => 'marek',
            'email' => 'bartula.marek@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('marro2'),
            'remember_token' => '',
            'role' => 1
        ]);
    }

}