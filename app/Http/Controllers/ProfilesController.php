<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{
    /**
     * Display a users profile and her adverts.
     * Display only active and verified adverts.
     * 
     * @param App\User $user
     * @return view
     */
    public function show(User $user) 
    {
        return view('profiles.show')->with([
            'profile' => $user,
            'adverts' => $user->adverts()->where('archived', false)->where('verified', true)->paginate(5)
        ]);
    }
}
