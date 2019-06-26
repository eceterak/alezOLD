<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Activity;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     * 
     * @return view
     */
    public function index() 
    {
        return view('admin.dashboard.index')->with([
            'activities' => Activity::latest()->with('subject')->limit(24)->get()
        ]);
    }
}
