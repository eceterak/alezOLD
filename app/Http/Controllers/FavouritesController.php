<?php

namespace App\Http\Controllers;

use App\Advert;

class FavouritesController extends Controller
{
    /**
     * User added advert to her favourites.
     * 
     * @param Advert $advert
     * @param $city
     * @return redirect
     */
    public function store($city, Advert $advert) 
    {
        $advert->favourite();

        return response(['status' => 'Dodano do ulubionych.']);
    }

    /**
     * User removed advert from her favourites.
     * 
     * @param Advert $advert
     * @param $city
     * @return redirect
     */
    public function destroy($city, Advert $advert) 
    {
        $advert->unfavourite();
        
        return response(['status' => 'Usunięto z ulubionych.']);        
    }
}
