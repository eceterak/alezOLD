<?php

namespace Tests\Setup;

use App\City;
use App\Street;

class StreetFactory 
{

    /**
     * Create and return instance of a Street object.
     * 
     * @return App\Street
     */
    public function create() 
    {
        $city = factory(City::class)->create();

        return factory(Street::class)->create([
            'city_id' => $city->id,
        ]);
    }

    /**
     * Return a instance of a Street object without saving it to a database.
     * 
     * @return App\Street
     */
    public function raw() 
    {
        $city = factory(City::class)->create();

        return factory(Street::class)->raw([
            'city_id' => $city->id,
        ]);
    }
}