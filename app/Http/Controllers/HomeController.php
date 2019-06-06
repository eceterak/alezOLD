<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users.home')->with([
            'profile' => $user = auth()->user(),
            'adverts' => $user->adverts()->where('archived', false)->paginate(24)
        ]);
    }
}
