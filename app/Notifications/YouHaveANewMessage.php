<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class YouHaveANewMessage extends Notification
{
    use Queueable;

    /**
     * @var App\subject
     */
    public $subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($conversation)
    {
        $this->subject = $conversation;
    }

    /**
     * Get the notification's delivery channels.
     * If user has email notifications disabled, sent notification just trough database.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ($notifiable instanceof User && $notifiable->acceptsEmailNotifications()) ? ['database', 'mail'] : ['database'];
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
            'message' => 'Masz nowa wiadomosc '.$this->subject->advert->title,
            //'link' => route('adverts.show', [$this->city->slug, $this->advert->slug])
        ];
    }
}
