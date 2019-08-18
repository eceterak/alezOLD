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
            $name = (strpos(request()->search, ',')) ? strtolower(explode(',', request()->search)[0]) : request()->search;

            $city = City::where('name', $name)->orderBy('importance')->first();
        }
        
        if($city) 
        {
            $attributes = [
                $city->slug, 
            ];

            if(request()->filled('radius')) array_push($attributes, 'radius='.request('radius'));

            if(request()->filled('room_size')) array_push($attributes, 'roomsize='.request('room_size'));
            
            return redirect()->route('cities.show', $attributes);
        }
        
        return redirect()->route('adverts'); // City not found, display all adverts.
    }
}
