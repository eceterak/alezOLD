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
     * @param City $city
     * @return view
     */
    public function index(City $city) 
    {
        return view('admin.streets.index')->with([
            'city' => $city,
            'streets' => $city->streets()->paginate(1)
        ]);
    }

    /**
     * Display all streets of a city.
     * 
     * @param City $city
     * @return view
     */
    public function create(City $city) 
    {
        return view('admin.streets.create')->with([
            'city' => $city
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
     * @param City $city
     * @param Request $request
     * @return redirect
     */
    public function store(City $city, Request $request) 
    {
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
