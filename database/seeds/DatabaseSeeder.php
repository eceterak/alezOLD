<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\City;
use App\Street;
use Facades\Tests\Setup\AdvertFactory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Mail;
use App\Photo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Faker $faker)
    {   
        Mail::fake();

        $city = create(City::class, [
            'name' => 'Kraków',
            'community' => 'm. Kraków',
            'county' => 'm. Kraków',
            'state' => 'Małopolska',
            'lat' => 50.065045, 
            'lon' => 19.942371
        ]);

        $cityNearBy = create(City::class, [
            'name' => 'Wieliczka',
            'community' => 'm. Kraków',
            'county' => 'm. Kraków',
            'state' => 'Małopolska',
            'lat' => 49.987054, 
            'lon' => 20.064649
        ]);

        $street = create(Street::class, [
            'name' => 'Bochenka',
            'city_id' => $city->id
        ]);

        $marek = create(User::class, [
            'name' => 'marek',
            'email' => 'bartula.marek@gmail.com',
            'email_verified_at' => now(),
            'email_notifications' => false,
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
                'email_notifications' => false,
                'password' => Hash::make('test123'),
                'remember_token' => '',
                'role' => 0
            ]);

            $city->subscribe($user);

            $advert = AdvertFactory::ownedBy($user)->street($street)->create();

            create(Photo::class, [
                'advert_id' => $advert->id,
                'url' => 'photos/ANPWkwfMT5ztPlOovsLnC3UQAyJlCUU2ykdmGm6N.jpeg',
                'order' => 0
            ]);

            create(Photo::class, [
                'advert_id' => $advert->id,
                'url' => 'photos/F5Ls7pfWCVAXLUqNZ1bGJ4eNDfBOvvE1bBTwT0p6.jpeg',
                'order' => 1
            ]);

            create(Photo::class, [
                'advert_id' => $advert->id,
                'url' => 'photos/zZTmwO8CgbV568sq97O0J1WKbrfJ75BRskh1Ww61.jpeg',
                'order' => 2
            ]);

            $advert->inquiry($faker->paragraph, $marek);

            $advert->favourite($user);
        }

    }
}
