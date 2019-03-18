<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class AdminCitiesController extends Controller
{
    /**
     * Display all cities.
     * 
     * @return view
     */
    public function index() 
    {
        $cities = City::all();

        return view('admin.cities.index')->with([
            'cities' => $cities
        ]);
    }

    /**
     * Edit a city.
     * 
     * @return view
     */
    public function edit($name) 
    {
        $city = City::where('name', $name)->firstOrFail();

        return view('admin.cities.edit')->with([
            'city' => $city
        ]);
    }


    /**
     * Display a new city form.
     * 
     * @return view
     */
    public function create() 
    {
        return view('admin.cities.create');
    }

    /**
     * Create a new city.
     * 
     * @return redirect
     */
    public function store() 
    {
        $attributes = request()->validate([
            'name' => 'required'
        ]);

        City::create($attributes);

        return redirect('/admin/miasta');
    }
}
