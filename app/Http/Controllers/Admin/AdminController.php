<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Activity;

class AdminController extends Controller
{
    /**
     * Display admin dashboard.
     * 
     * @return view
     */
    public function index() 
    {
        return view('admin.dashboard.index')->with([
            'activities' => Activity::latest()->limit(20)->get()
        ]);
    }
    
    /**
     * Display login page.
     * 
     * @return view
     */
    public function login() 
    {
        return view('admin.auth.login');
    }
}
