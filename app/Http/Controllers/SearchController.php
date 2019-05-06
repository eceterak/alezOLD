<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class SearchController extends Controller
{

    /**
     * Search for a city. If city_id is provided, job is done. If not perform a classic search.
     * 
     * @param Request $request
     * @return redirect
     */
    public function index(Request $request)
    {
        if(!is_null($request->city_id)) {
            $city = City::find($request->city_id);
        }
        elseif(is_null($request->city) && is_null($request->city_id)) {
            return redirect()->route('rooms');
        }
        else {
            $name = (strpos($request->city, ',')) ? strtolower(explode(',', $request->city)[0]) : $request->city;

            $city = City::where('name', $name)->firstOrFail();
        }
        
        return redirect()->route('cities.show', [$city->slug]);
       
    }
}
