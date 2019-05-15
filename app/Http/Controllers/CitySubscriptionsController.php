<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class CitySubscriptionsController extends Controller
{
    /**
     * 
     * @param City $city
     * @return void
     */
    public function store(City $city) 
    {
        $city->subscribe();
    }

    /**
     * 
     * @param City $city
     * @return void
     */
    public function destroy(City $city) 
    {
        $city->unsubscribe();
    }
}
