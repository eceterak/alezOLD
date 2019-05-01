<?php

namespace App\Http\Controllers;

use App\City;

class CitiesController extends Controller
{
    /**
     * Display all cities.
     * 
     * @return view
     */
    public function index() 
    {
        $cities = City::limit(10)->get();

        return view('cities.index')->withCities($cities);
    }

    /**
     * Display a city.
     * @param string $slug
     * 
     * @return view
     */
    public function show($slug) 
    {
        return view('cities.show')->with([
            'city' => City::getBySlug($slug)
        ]);    
    }
}
