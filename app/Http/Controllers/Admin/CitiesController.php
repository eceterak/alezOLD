<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $cities = City::all();

        return view('admin.cities.index')->with([
            'cities' => $cities
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

    /**
     * Edit a city.
     * 
     * @param string $name
     * @return view
     */
    public function edit($name) 
    { 
        $city = City::where('name', parsePath($name))->firstOrFail();
        
        return view('admin.cities.edit')->with([
            'city' => $city
        ]);
    }
        
    /**
     * Update a city.
     * 
     * @param string $path
     * @return redirect
     */
    public function update($path) 
    {
        $city = City::where('name', parsePath($path))->firstOrFail();

        $city->update([
            'name' => request('name'),
            'suggested' => request()->has('suggested')
        ]);

        return redirect()->route('admin.cities');
    }
}
