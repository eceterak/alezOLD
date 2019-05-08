<?php

namespace App\Http\Controllers;

use App\City;
use App\AdvertFilters;
use App\Advert;

class CitiesController extends Controller
{
    /**
     * Display all cities.
     * 
     * @return view
     */
    public function index() 
    {
        return view('cities.index')->with([
            'cities' => City::paginate(10)
        ]);
    }

    /**
     * Display a city.
     * 
     * @param City $city
     * @return view
     */
    public function show(City $city, AdvertFilters $filters) 
    {
        return view('cities.show')->with([
            'city' => $city,
            'adverts' => Advert::filter($filters)->where('city_id', $city->id)->get()
        ]);    
    }
}
