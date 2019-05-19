<?php

namespace App\Http\Controllers;

use App\City;

class CitySubscriptionsController extends Controller
{
    /**
     * Add city to subscriptions.
     * 
     * @param City $city
     * @return void
     */
    public function store(City $city) 
    {
        $city->subscribe();
    }

    /**
     * Remove city from subscriptions.
     * 
     * @param City $city
     * @return void
     */
    public function destroy(City $city) 
    {
        $city->unsubscribe();
    }
}
