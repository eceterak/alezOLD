<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filters\AdvertFilters;
use App\Advert;
use App\City;
use App\Http\Requests\CreateAdvertRequest;

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
     * @param Advert $advert
     * @return view
     */
    public function show(City $city, Advert $advert) 
    {   
        $advert->increment('visits');

        return view('adverts.show')->with([
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
     * @Refactor
     * @param Request $request
     * @return redirect
     */
    public function store(CreateAdvertRequest $request) 
    {
        // Get temporary advert
        //$temporary = Advert::getTemporary($request->temp, $request->token);

        $advert = auth()->user()->adverts()->create($request->validated()); // @refactor user->addAdvert();

        if(request()->wantsJson())
        {
            return response($advert, 201);
        }

        // Update images

        // Delete temporary advert
        //$temporary->delete();

        return redirect(route('home'))
            ->with('flash', 'Ogloszenie dodane');
    }
    
    /**
     * Edit an advert.
     * 
     * @param City $city
     * @param Advert $advert
     * @return view
     */
    public function edit(City $city, Advert $advert) 
    {      
        $this->authorize('update', $advert);

        return view('adverts.edit')->with([
            'advert' => $advert
        ]);
    }

    /**
     * Update an advert.
     * 
     * @param City $city
     * @param Advert $advert
     * @return redirect
     */
    public function update(City $city, Advert $advert) 
    {        
        $this->authorize('update', $advert);

        $advert->update($this->validateRequest());

        return redirect(route('adverts'));
    }

    /**
     * Delete an advert. Accept id instead of slug.
     * 
     * @param City $city
     * @param Advert $advert
     * @return redirect
     */
    public function destroy(City $city, Advert $advert) 
    {
        $this->authorize('update', $advert);

        $advert->delete();

        if(request()->expectsJson())
        {
            return response(['status' => 'Ogłoszenie usunięte']);
        }
     
        return redirect(route('home'));        
    }

    /**
     * Validate a request.
     * 
     * @return array
     */
    protected function validateRequest() 
    {
        $attributes = request()->validate([
            'city_id' => 'required|exists:cities,id',
            'street_id' => 'sometimes|exists:streets,id',
            'title' => 'required|spamfree',
            'description' => 'required|spamfree',
            'available_from' => 'nullable',
            'minimum_stay' => 'nullable',
            'maximum_stay' => 'nullable',
            'landlord' => 'sometimes',
            'rent' => 'required',
            'deposit' => 'sometimes',
            'bills' => 'sometimes',
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

        return $attributes;
    }
}
