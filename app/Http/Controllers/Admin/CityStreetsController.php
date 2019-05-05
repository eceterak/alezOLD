<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Street;
use App\City;

class CityStreetsController extends Controller
{
    /**
     * Display all streets of a city.
     * 
     * @param string $slug
     * @return view
     */
    public function index($slug) 
    {
        return view('admin.streets.index')->with([
            'city' => City::getBySlug($slug)
        ]);
    }

    /**
     * Display all streets of a city.
     * 
     * @param string $slug
     * @return view
     */
    public function create($slug) 
    {
        return view('admin.streets.create')->with([
            'city' => City::getBySlug($slug)
        ]);
    }

    /**
     * Display edit form.
     * 
     * @param string $city
     * @param string $street
     * @return view
     */
    public function edit($city, $id)
    {
        return view('admin.streets.edit')->with([
            'street' => Street::findOrFail($id)
        ]);
    }

    /**
     * Store new street of the city.
     * 
     * @param string $city
     * @param Request $request
     * @return redirect
     */
    public function store($city, Request $request) 
    {
        $city = City::getBySlug($city);

        $city->addStreet($request->validate([
            'name' => 'required',
            'type' => 'sometimes',
            'lat' => 'required',
            'lon' => 'required',
            'importance' => 'sometimes',
            'ct' => 'sometimes'
        ]));

        return redirect(route('admin.cities.streets', $city->slug));
    }

    /**
     * Update a street.
     * 
     * @param string $city
     * @param string $street
     * @param Request $request
     * @return redirect
     */
    public function update($city, $id, Request $request) 
    {           
        $street = Street::findOrFail($id);

        $street->update($request->validate([
            'name' => 'required',
            'type' => 'sometimes',
            'lat' => 'required',
            'lon' => 'required',
            'importance' => 'sometimes',
            'ct' => 'sometimes'
        ]));

        return redirect()->route('admin.cities.streets', $street->city->slug);
    }

    /**
     * Delete a street.
     * 
     * @param $city
     * @param Street $street
     * @return redirect
     */
    public function destroy($city, Street $street) 
    {
        $street->delete();

        return redirect()->route('admin.cities.streets', $street->city->slug);
    }

}
