<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class CitiesController extends Controller
{
    /**
     * 
     * 
     * @return
     */
    public function index() 
    {
        $cities = City::all();

        return view('cities.index')->withCities($cities);
    }

    /**
     * 
     * 
     * @return
     */
    public function show($name) 
    {
        $city = City::where('name', parsePath($name))->firstOrFail();
        
        return view('cities.show')->with([
            'city' => $city
        ]);    
    }
}
