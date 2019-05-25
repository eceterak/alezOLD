<?php

namespace App\Http\Controllers;

use App\City;

class SearchController extends Controller
{
    /**
     * Search for a city. If city_id is provided, job is done. If not, perform a classic search.
     * If city is found, redirect to it's page. In any other case, just display all adverts.
     * 
     * @return redirect
     */
    public function index()
    {
        if(!is_null(request()->city_id)) 
        {
            $city = City::find(request()->city_id);
        }
        else 
        {
            $name = (strpos(request()->city, ',')) ? strtolower(explode(',', request()->city)[0]) : request()->city;

            $city = City::where('name', $name)->orderBy('importance')->first();
        }

        if($city) return redirect()->route('cities.show', [$city->slug]);
        
        return redirect()->route('adverts'); // City not found, display all adverts.
    }

    public function test()
    {
        
    }
}
