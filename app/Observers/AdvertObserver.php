<?php

namespace App\Observers;

use App\Mail\AdvertCreatedConfirmationMail;
use App\Notifications\AdvertWasAdded;
use Illuminate\Support\Facades\Mail;
use App\Advert;

class AdvertObserver
{
    /**
     * Generate the slug using advert title.
     * 
     * @param  \App\Advert $advert
     * @return void
     */
    public function creating(Advert $advert)
    {
        $advert->slug = $advert->title;
    }

    /**
     * Send a confirmation mail.
     * 
     * @param  \App\Advert $advert
     * @return void
     */
    public function created(Advert $advert)
    {
        $advert->city->subscriptions
            ->where('user_id', '!=', $advert->user_id)
            ->each(function($subscription) use ($advert) {
                $subscription->user->notify(new AdvertWasAdded($advert->city, $advert));
            });

        Mail::to($advert->user)->send(new AdvertCreatedConfirmationMail());
    }

    /**
     * Update slug if title has changed.
     *
     * @param  \App\Advert  $advert
     * @return void
     */
    public function updating(Advert $advert)
    {        
        if($advert->isDirty('title') && $advert->isClean('slug')) $advert->slug = $advert->title;
    }
}
