<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    /**
     * Index.
     * 
     * @return view
     */
    public function index() 
    {
        return view('pages.index');
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
