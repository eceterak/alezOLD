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
     * @var App\City
     */
    protected $city;

    /**
     * @var App\Advert
     */
    public $subject;

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
    public function toDatabase($notifiable)
    {
        $message = '<small>Nowe ogłoszenie w <a href="'.route('cities.show', $this->city->slug).'">'.$this->city->name.'</a></small>
                    <a href="'.route('adverts.show', [$this->city->slug, $this->subject->slug]).'">'.$this->subject->title.'</a>';

        return [
            'message' => $message,
            'date' => $this->subject->created_at->diffForHumans()
        ];
    }
}
