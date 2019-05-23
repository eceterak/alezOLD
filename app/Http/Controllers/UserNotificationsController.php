<?php

namespace App\Http\Controllers;

class UserNotificationsController extends Controller
{
    /**
     * Fetch all unread notifications for a authenticated user.
     * Always use auth()->user() so no one will play with 
     * fetching notifications for given user name.
     * 
     * @param string $user
     * @return void
     */
    public function index($user) 
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Mark given notification as read.
     * 
     * @param string $user
     * @return void
     */
    public function destroy($user, $notificationId) 
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
