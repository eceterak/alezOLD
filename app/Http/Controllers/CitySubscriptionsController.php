<?php

namespace App\Http\Controllers;

use App\City;

class CitySubscriptionsController extends Controller
{
    /**
     * User is adding city to subscribed and will receive 
     * notifications about new adverts added to it.
     * 
     * @param City $city
     * @return void
     */
    public function store(City $city) 
    {
        $city->subscribe();
    }

    /**
     * User removes city from subscribed.
     * 
     * @param City $city
     * @return void
     */
    public function destroy(City $city) 
    {
        $city->unsubscribe();
    }
}
