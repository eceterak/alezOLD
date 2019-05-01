<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if(!is_null($request->city_id)) {
            $city = City::find($request->city_id);
        }
        elseif(is_null($request->city) && is_null($request->city_id)) {
            return redirect()->route('rooms');
        }
        else {
            $city = City::where('name', $request->city)->firstOrFail();
        }
        
        return redirect()->route('cities.show', [$city->slug]);
       
    }
}
