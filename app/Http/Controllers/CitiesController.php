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
        $city = City::where('name', $name)->firstOrFail();

        return view('cities.show')->withCity($city);        
    }

    public function create() 
    {
        return view('cities.create');
    }

    /**
     * 
     * 
     * @return
    */
    public function store() 
    {
        $attributes = request()->validate([
            'name' => 'required'
        ]);

        City::create($attributes);

        return redirect('/miasta');
    }
    
    /**
     * 
     * 
     * @return
    */
    public function edit($name) 
    {
        $city = City::where('name', $name)->firstOrFail();

        return view('cities.edit')->withCity($city);
    }
}
