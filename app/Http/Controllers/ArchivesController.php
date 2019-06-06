<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArchivesController extends Controller
{
    /**
     * Display users archived adverts.
     * 
     * @return
     */
    public function index() 
    {
        return view('users.archives')->with([
            'profile' => $user = auth()->user(),
            'adverts' => $user->adverts()->where('archived', true)->paginate(24)
        ]);
    }
}
