<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advert;

class AdminAdvertsController extends Controller
{

    /**
     * Display all adverts.
     * 
     * @return view
     */
    public function index() 
    {
        $adverts = Advert::all();

        return view('admin.adverts.index')->with([
            'adverts' => $adverts
        ]);
    }

    /**
     * Create a new advert.
     * 
     * @return view
     */
    public function create() 
    {
        return view('admin.adverts.create');
    }

    /**
     * Store an advert.
     * 
     * @return redirect
     */
    public function store() 
    {
        $attributes = request()->validate([
            'city_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'rent' => 'required'
        ]);

        auth()->user()->adverts()->create($attributes);

        return redirect(route('admin.adverts'));
    }
}
