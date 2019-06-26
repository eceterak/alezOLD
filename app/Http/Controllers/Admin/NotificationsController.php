<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    /**
     * Display all admin notifications.
     * 
     * @return view
     */
    public function index() 
    {
        return view('admin.notifications.index')->with([
            'notifications' => auth()->user()->unreadNotifications()->latest()->paginate(24)
        ]);
    }
}
