<?php

namespace App\Http\Controllers;

use App\City;
use App\RoomFilters;
use App\Room;

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
     * @param string $slug
     * @return view
     */
    public function show($slug, RoomFilters $filters) 
    {
        return view('cities.show')->with([
            'city' => $city = City::getBySlug($slug),
            'rooms' => Room::filter($filters)->where('city_id', $city->id)->get()
        ]);    
    }
}
