<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Advert;

class AdvertVerifiedConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var App\Advert
     */
    public $advert;

    /**
     * Create a new message instance.
     *
     * @param Advert $advert
     * @return void
     */
    public function __construct(Advert $advert)
    {
        $this->advert = $advert;

        $this->subject = 'alez.pl - Twoje ogłoszenie zostało pomyślnie zweryfikowane.';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('alez@alez.pl')->markdown('emails.adverts.verified-confirmation');
    }
}
