<?php

namespace App\Http\Controllers;

use App\Advert;
use App\City;

class FavouritesController extends Controller
{
    /**
     * Favourite an advert.
     * 
     * @param Advert $advert
     * @param City $city
     * @return redirect
     */
    public function store(City $city, Advert $advert) 
    {
        $advert->favourite();

        return response(['status' => 'Dodano do ulubionych.']);
    }

    /**
     * Unfavourite an advert.
     * 
     * @param Advert $advert
     * @param City $city
     * @return redirect
     */
    public function destroy(City $city, Advert $advert) 
    {
        $advert->unfavourite();
        
        return response(['status' => 'Usunięto z ulubionych.']);        
    }
}
