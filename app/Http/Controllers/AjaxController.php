<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Street;

class AjaxController extends Controller
{
    public function cities(Request $request) 
    {
        $city = $request->city;

        $cities = City::where('name', 'LIKE', '%'.$city.'%')
                        ->orderBy('importance', 'desc')
                        ->limit(10)
                        ->select('id', 'name', 'county', 'state')
                        ->get();

        return response()->json($cities);
    }

    public function streets(Request $request) 
    {
        $streets = Street::where('city_id', $request->city_id)
                        ->select('id', 'name')
                        ->get();

        return response()->json($streets);
    }
}
