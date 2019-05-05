<?php

namespace App\Http\Controllers;

use App\City;

class PagesController extends Controller
{
    /**
     * Index.
     * 
     * @return view
     */
    public function index() 
    {
        return view('pages.index')->with([
            'cities' => City::where('suggested', true)->get()
        ]);
    }

    /**
     * User's home
     * 
     * @return view
     */
    public function home()
    {
        return view('pages.home');
    }
}
