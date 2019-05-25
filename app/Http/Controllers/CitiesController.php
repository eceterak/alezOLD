<?php

namespace App\Http\Controllers;

use App\Filters\AdvertFilters;
use App\City;
use App\Advert;
use Illuminate\Support\Facades\Input;

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
     * Display a city with its adverts.
     * 
     * @param City $city
     * @param AdvertFilters $filters
     * @return view
     */
    public function show(City $city, AdvertFilters $filters) 
    {        
        $adverts = $this->getAdverts($city, $filters);

        // Leave it in the case I will use and vue to display advers.
        if(request()->wantsJson())
        {
            return $adverts;
        }

        return view('cities.show')->with([
            'city' => $city,
            'adverts' => $adverts
        ]);    
    }

    /**
     * Get adverts from a given city, apply filters if any are set.
     * 
     * @param City $city
     * @param AdvertFilters $filters
     * @return view
     */
    protected function getAdverts(City $city, AdvertFilters $filters)
    {
        $adverts = Advert::latest()->filter($filters);

        if($city->exists)
        {
            $adverts->where('city_id', $city->id);
        }

        // Append any get parameters to keep them in url after navigating to a different page.
        return $adverts->paginate(20)->appends(Input::except('page'));
    }
}
