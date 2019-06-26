<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdvertNeedsRevision extends Notification
{
    use Queueable;

    /**
     * @var App\Advert
     */
    public $subject;

    /**
     * Create a new notification instance.
     * 
     * @param   Advert  $advert
     * @return  void
     */
    public function __construct($advert)
    {
        $this->subject = $advert;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'link' => route('admin.adverts.edit', $this->subject->slug),
            'message' => $this->subject->user->name.' zaaktualizował(a) ogłoszenie',
            'date' => $this->subject->created_at->diffForHumans()
        ];
    }
}