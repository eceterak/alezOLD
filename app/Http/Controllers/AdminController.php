<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a admin dashboard.
     * 
     * @return view
     */
    public function index() 
    {
        return view('admin.index');
    }
    
    /**
     * 
     * 
     * @return
     */
    public function login() 
    {
        return view('admin.auth.login');
    }
}
