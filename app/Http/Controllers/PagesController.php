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
            'suggestedCities' => City::where('suggested', true)->limit(12)->orderBy('importance', 'DESC')->get()
        ]);
    }

    /**
     * 
     * 
     * @return view
     */
    public function termsAndConditions() 
    {
        return view('pages.termsAndConditions');
    }

    /**
     * 
     * 
     * @return view
     */
    public function aboutUs() 
    {
        return view('pages.aboutUs');
    }

    /**
     * 
     * 
     * @return view
     */
    public function privacyPolicy() 
    {
        return view('pages.privacyPolicy');
    }
}
