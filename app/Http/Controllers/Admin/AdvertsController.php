<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Advert;

class AdvertsController extends Controller
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
     * 
     * 
     * @return
     */
    public function edit($city, $title) 
    {
        var_dump($city);
        var_dump($title);
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
