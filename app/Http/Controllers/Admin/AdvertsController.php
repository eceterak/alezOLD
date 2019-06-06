<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Advert;

class AdvertsController extends Controller
{

    /**
     * Display all Adverts.
     * 
     * @return view
     */
    public function index() 
    {
        return view('admin.adverts.index')->with([
            'adverts' => Advert::latest()->get()
        ]);
    }

    /**
     * Display new Advert form.
     * 
     * @return view
     */
    public function create() 
    {
        return view('admin.adverts.create');
    }

    /**
     * Display an edit form.
     * 
     * @param Advert $advert
     * @return view
     */
    public function edit(Advert $advert) 
    {
        return view('admin.adverts.edit')->with([
            'advert' => $advert
        ]);
    }

    /**
     * Store a new Advert in a database.
     * 
     * @param Request $request
     * @return redirect
     */
    public function store(Request $request) 
    {
        $attributes = $this->validateRequest($request);
        $attributes['slug'] = $request->title;

        $advert = auth()->user()->adverts()->create($attributes);

        return redirect(route('admin.adverts'));
    }

    /**
     * Update a Advert.
     * 
     * @param Advert $advert
     * @param Request $request
     * @return redirect
     */
    public function update(Advert $advert, Request $request) 
    {
        if($request->verified) $advert->verify();
        else
        {
            $attributes = $this->validateRequest($request);
            $attributes['slug'] = $request->title;
            $advert->update($attributes);
        }

        return redirect(route('admin.adverts'));
    }

    /**
     * Delete a Advert.
     * 
     * @return redirect
     */
    public function destroy(Advert $Advert) 
    {
        $Advert->delete();

        return redirect(route('admin.adverts'));
    }
    
    /**
     * Validate a data.
     * 
     * @param Request $request
     * @return array
     */
    protected function validateRequest() 
    {
        return request()->validate([
            'city_id' => 'required',
            'street_id' => 'sometimes',
            'title' => 'required',
            'description' => 'required',
            'available_from' => 'sometimes',
            'minimum_stay' => 'sometimes',
            'maximum_stay' => 'sometimes',
            'landlord' => 'sometimes',
            'rent' => 'required',
            'deposit' => 'sometimes',
            'bills' => 'required',
            'property_type' => 'sometimes',
            'property_size' => 'sometimes',
            'living_room' => 'sometimes',
            'room_size' => 'sometimes',
            'furnished' => 'sometimes',
            'broadband' => 'sometimes',
            'smoking' => 'sometimes',
            'pets' => 'sometimes',
            'occupation' => 'sometimes',
            'couples' => 'sometimes',
            'gender' => 'sometimes',
            'minimum_age' => 'sometimes',
            'maximum_age' => 'sometimes'
        ]);
    }
}
