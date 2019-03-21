<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
