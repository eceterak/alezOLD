<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{
    /**
     * Specify where to redirect after successful login.
     * 
     * @return string
     */
    protected function redirectTo() 
    {
        if(Auth::user()->isAdmin()) return '/admin';

        return '/';
    }

    /**
     * Display login page.
     * 
     * @return view
     */
    public function index() 
    {
        return view('admin.auth.login');
    }
}
