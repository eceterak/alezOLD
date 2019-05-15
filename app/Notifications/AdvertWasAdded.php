<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdvertWasAdded extends Notification
{
    use Queueable;

    /**
     * @var
     */
    protected $city;

    /**
     * @var
     */
    protected $advert;

    /**
     * Create a new notification instance.
     * 
     * @param City $city
     * @param Advert $advert
     * @return void
     */
    public function __construct($city, $advert)
    {
        $this->city = $city;
        $this->advert = $advert;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Nowe ogłoszenie w '.$this->city->name,
            'link' => route('adverts.show', [$this->city->slug, $this->advert->slug])
        ];
    }
}
