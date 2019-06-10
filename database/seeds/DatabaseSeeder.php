<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\City;
use App\Street;
use Facades\Tests\Setup\AdvertFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        $city = create(City::class, [
            'name' => 'Kraków',
            'community' => 'm. Kraków',
            'county' => 'm. Kraków',
            'state' => 'Małopolska'
        ]);

        $street = create(Street::class, [
            'name' => 'Bochenka',
            'city_id' => $city->id
        ]);

        create(User::class, [
            'name' => 'marek',
            'email' => 'bartula.marek@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('marro2'),
            'remember_token' => '',
            'role' => 1
        ]);

        for($i = 0; $i < 10; $i++)
        {
            $user = create(User::class, [
                'name' => 'test-'.$i,
                'email' => $i.'-test@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('test123'),
                'remember_token' => '',
                'role' => 0
            ]);

            $city->subscribe($user);

            AdvertFactory::ownedBy($user)->street($street)->create();
        }

    }
}
