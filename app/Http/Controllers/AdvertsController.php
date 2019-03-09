<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advert;

class AdvertsController extends Controller
{

    /**
     * 
     * 
     * @return view
     */
    public function index() 
    {
        $adverts = Advert::all();
        
        return view('adverts.index')->withAdverts($adverts);
    }

    /**
     * 
     * 
     * @return view
     */
    public function show(Advert $advert) 
    {        
        return view('adverts.show')->withAdvert($advert);
    }

    /**
     * 
     * 
     * @return view
     */
    public function edit(Advert $advert) 
    {    
        if(auth()->user()->isNot($advert->user)) {
            abort(403);
        }
        
        return view('adverts.edit')->withAdvert($advert);
    }

    /**
     * 
     * 
     * @return
    */
    public function create() 
    {
        return view('adverts.create');
    }

    /**
     * 
     * 
     * @return redirect
     */
    public function store() {
        $attributes = request()->validate([
            'city_id' => 'required',
            'title' => 'required', 
            'description' => 'required', 
            'rent' => 'required'
        ]);

        auth()->user()->adverts()->create($attributes);

        return redirect('/pokoje');
    }
}
