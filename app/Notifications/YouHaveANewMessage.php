<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Message;
use App\Advert;

class YouHaveANewMessage extends Notification
{
    use Queueable;

    /**
     * @var App\Message
     */
    public $subject;

    /**
     * @var App\Advert
     */
    public $advert;

    /**
     * Create a new notification instance.
     *
     * @param Message $message
     * @param Advert $advert
     * @return void
     */
    public function __construct(Message $message, Advert $advert)
    {
        $this->subject = $message;

        $this->advert = $advert;
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
        return (new MailMessage)->subject('alez.pl - masz nową wiadomość od '.ucfirst($this->subject->user->name))
                                ->from('alez@alez.pl')
                                ->replyTo($this->subject->user->email)
                                ->markdown('emails.conversations.new-message', [
                                    'to' => $this->subject->receiver,
                                    'from' => $this->subject->user,
                                    'message' => $this->subject,
                                    'advert' => $this->advert
                                ]);
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
            'message' => 'Masz nowa wiadomosc'
        ];
    }
}
