<?php

namespace App\Http\Controllers;

use App\City;

class PagesController extends Controller
{
    /**
     * Index. Get and display suggested cities.
     * 
     * @return view
     */
    public function index() 
    {
        return view('pages.index')->with([
            'cities' => City::where('suggested', true)->limit(12)->orderBy('importance', 'DESC')->get()
        ]);
    }
}
