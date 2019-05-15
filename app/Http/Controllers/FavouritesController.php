<?php

namespace App\Http\Controllers;

use App\Advert;

class FavouritesController extends Controller
{
    /**
     * Favourite an advert.
     * 
     * @param Advert $advert
     * @return redirect
     */
    public function store(Advert $advert) 
    {
        $advert->favourite();

        return back();
    }

    /**
     * Unfavourite an advert.
     * 
     * @param Advert $advert
     * @return redirect
     */
    public function destroy(Advert $advert) 
    {
        $advert->unfavourite();        

        //return back();
    }
}
