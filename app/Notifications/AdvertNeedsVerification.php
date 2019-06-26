<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdvertNeedsVerification extends Notification
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
        $message = $this->subject->user->name.' dodał(a) nowe ogłoszenie do zweryfikowania w <a href="'.route('admin.cities.edit', $this->subject->city->slug).'">'.$this->subject->city->name.'</a>';

        return [
            'link' => route('admin.adverts.edit', $this->subject->slug),
            'message' => $message,
            'date' => $this->subject->created_at->diffForHumans()
        ];
    }
}
