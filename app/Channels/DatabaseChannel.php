<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Channels\DatabaseChannel as IlluminateDatabaseChannel;

class DatabaseChannel extends IlluminateDatabaseChannel
{

    /**
     * Overwrite custom database channel to expand notifications table with subject columns.
     * 
     * @param App\User $notifiable
     * @param Notification $notification
     * @return 
     */
    public function send($notifiable, Notification $notification)
    {
        return $notifiable->routeNotificationFor('database')->create([
            'id'      => $notification->id,
            'type'    => get_class($notification),
            'subject_type' => get_class($notification->subject),
            'subject_id' => $notification->subject->id,
            'data'    => $this->getData($notifiable, $notification),
            'read_at' => null
        ]);
    }
}