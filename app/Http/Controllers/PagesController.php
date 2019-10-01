<?php

namespace App\Http\Controllers;

use App\City;
use App\Advert;

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
            'suggestedCities' => City::where('suggested', true)->limit(3)->orderBy('importance', 'DESC')->get(),
            'adverts' => Advert::orderBy('visits', 'DESC')->where('verified', true)->where('archived', false)->limit(6)->get()
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

    /**
     * 
     * 
     * @return view
     */
    public function contact() 
    {
        return view('pages.contact');
    }
}
