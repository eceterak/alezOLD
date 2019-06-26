<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class ProfilesController extends Controller
{
    /**
     * Display all users.
     * 
     * @return view
     */
    public function index() 
    {
        return view('admin.profiles.index')->with([
            'profiles' => User::withCount('adverts')->paginate(24)
        ]);
    }
}
