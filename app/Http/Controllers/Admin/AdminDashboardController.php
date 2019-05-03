<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    /**
     * Display a dashboard.
     * 
     * @return view
     */
    public function index() 
    {
        return view('admin.index');
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
