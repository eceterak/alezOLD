<?php

namespace App\Http\Controllers;

use App\User;

class UserNotificationsController extends Controller
{
    /**
     * Apply a middleware.
     * 
     * @return
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mark given notification as read.
     * 
     * @return void
     */
    public function index(User $user) 
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Mark given notification as read.
     * 
     * @return void
     */
    public function destroy(User $user, $notificationId) 
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
