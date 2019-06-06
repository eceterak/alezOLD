<?php

namespace App\Http\Controllers;

use App\Advert;

class FavouritesController extends Controller
{
    /**
     * Display all favourites adverts.
     * 
     * @param Advert $advert
     * @param $city
     * @return redirect
     */
    public function index() 
    {
        $favourites = auth()->user()->favourites()->paginate(24);
        
        // If user deleted a favourite and is redirected back to an empty page,
        // redirect her forward to a first page with content.
        if(!$favourites->count()) 
        {
            if(!is_null($favourites->previousPageUrl()))
            {
                return redirect()->to($favourites->previousPageUrl());
            }
        }

        return view('users.favourites.index')->with([
            'profile' => $user = auth()->user(),
            'favourites' => $favourites
        ]);
    }

    /**
     * User adding advert to her favourites.
     * 
     * @param Advert $advert
     * @param $city
     * @return redirect
     */
    public function store($city, Advert $advert) 
    {
        $advert->favourite();

        if(request()->wantsJson()) return response(['status' => 'Dodano do ulubionych.']);
        
        return redirect()->back();
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
                
        if(request()->wantsJson()) return response(['status' => 'Usunięto z ulubionych.']);     
        
        return redirect()->back();
    }
}
