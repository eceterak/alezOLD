<?php

namespace App\Http\Controllers;

class HomeMobileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users.home-mobile')->with([
            'profile' => auth()->user()
        ]);
    }
}
