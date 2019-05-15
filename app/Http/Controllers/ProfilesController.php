<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfilesController extends Controller
{
    /**
     * 
     * 
     * @return
     */
    public function show(User $user) 
    {
        return view('profiles.show')->with([
            'profile' => $user,
            'adverts' => $user->adverts()->paginate(5)
        ]);
    }
}
