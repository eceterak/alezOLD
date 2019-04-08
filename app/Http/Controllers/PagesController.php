<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * 
     * 
     * @return
     */
    public function index() 
    {
        return view('pages.index');
    }

    /**
     * 
     * @returneb
     */
    public function home()
    {
        return view('pages.home');
    }
}
