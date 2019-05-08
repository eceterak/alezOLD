<?php

namespace Tests\Setup;

use App\City;
use App\Advert;
use App\User;

class CityFactory 
{
    protected $advertsCount = 0;
    
    protected $user;

    /**
     * 
     * 
     * @return
     */
    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * 
     * 
     * @return
     */
    public function withRooms($count) 
    {
        $this->advertsCount = $count;

        return $this;
    }

    /**
     * 
     * 
     * @return
     */
    public function create() 
    {
        $city = factory(City::class)->create();

        factory(Advert::class, $this->advertsCount)->create([
            'city_id' => $city->id,
            'user_id' => $this->user ?? factory(User::class)
        ]);

        return $city;
    }
}