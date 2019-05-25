<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserSettingsController extends Controller
{
    /**
     * Display user settings page.
     * 
     * @return
     */
    public function index() 
    {
        return view('users.settings')->with([
            'profile' => auth()->user()
        ]);
    }
}
