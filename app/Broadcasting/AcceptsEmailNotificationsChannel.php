<?php

namespace App\Broadcasting;

use Illuminate\Notifications\Channels\MailChannel;
use App\User;

class AcceptsEmailNotificationsChannel extends MailChannel
{
    public function send($notifiable, \Illuminate\Notifications\Notification $notification)
    {
        if($notifiable instanceof User && !$notifiable->acceptsEmailNotifications())
        {
            return;
        }

        $message = $notification->toMail($notifiable);

        if(!$message)
        {
            return;
        }

        parent::send($notifiable, $notification);
    }
}
