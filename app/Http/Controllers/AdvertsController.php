<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdvertFilters;
use App\Advert;
use App\City;

class AdvertsController extends Controller
{

    /**
     * Display all available Adverts.
     * To filter the results use AdvertFilters which are injected trough route model binding.
     * 
     * @param AdvertFilters $filters
     * @return view
     */
    public function index(AdvertFilters $filters) 
    {
        return view('adverts.index')->with([
            'adverts' => Advert::filter($filters)->get()
        ]);
    }

    /**
     * Display a single advert.
     * 
     * @param City $city
     * @param string $slug
     * @return view
     */
    public function show(City $city, $slug) 
    {   
        return view('adverts.show')->with([
            'advert' => Advert::getBySlug($slug)
        ]);
    }
    
    /**
     * Edit an advert.
     * 
     * @param string $path
     * @return view
     */
    public function edit($path) 
    {
        $advert = Advert::getBySlug($path);
        
        $this->authorize('update', $advert);

        return view('adverts.edit')->with([
            'advert' => $advert
        ]);
    }

    /**
     * Display a create new advert form.
     * 
     * @return view
     */
    public function create() 
    {
        return view('adverts.create')->with([
            'temp' => Advert::temporary()
        ]);
    }

    /**
     * Store a new advert in a database.
     * 
     * @param Request $request
     * @return redirect
     */
    public function store(Request $request) 
    {
        auth()->user()->adverts()->create($this->validateRequest($request));
        // Get temporary advert
        $temporary = Advert::getTemporary($request->temp, $request->token);

        // Create new advert

        // Update images

        // Delete temporary advert
        $temporary->delete();

        return redirect(route('home'));
    }

    /**
     * Update an advert.
     * 
     * @param string $slug
     * @param Request $request
     * @return redirect
     */
    public function update($slug, Request $request) 
    {
        $advert = Advert::getBySlug($slug);
        
        $this->authorize('update', $advert);

        $advert->update($this->validateRequest($request));

        $advert->generateSlug();

        return redirect(route('adverts'));
    }

    /**
     * Delete an advert. Accept id instead of slug.
     * 
     * @param Advert $advert
     * @return redirect
     */
    public function destroy(Advert $advert) 
    {
        $this->authorize('update', $advert);

        $advert->delete();
     
        return redirect(route('home'));        
    }

    /**
     * Validate a request.
     * 
     * @param Request $request
     * @return array
     */
    protected function validateRequest($request) 
    {
        return request()->validate([
            'city_id' => 'required|exists:cities,id',
            'street_id' => 'sometimes|exists:streets,id',
            'title' => 'required',
            'description' => 'required',
            'available_from' => 'nullable',
            'minimum_stay' => 'nullable',
            'maximum_stay' => 'nullable',
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