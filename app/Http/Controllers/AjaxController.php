<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class AjaxController extends Controller
{
    public function cities(Request $request) 
    {
        $city = $request->city;

        $cities = City::where('name', 'LIKE', '%'.$city.'%')->limit(5)->get();

        return response()->json($cities);
    }
}
