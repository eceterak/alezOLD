<?php

namespace App\Observers;

use App\Mail\AdvertCreatedConfirmationMail;
use App\Notifications\AdvertWasAdded;
use Illuminate\Support\Facades\Mail;
use App\Advert;

class AdvertObserver
{
    /**
     * Generate a slug when creating a new room.
     * 
     * @param  \App\Advert $advert
     * @return void
     */
    public function created(Advert $advert)
    {
        $advert->update(['slug' => $advert->title]);

        $advert->city->subscriptions
            ->where('user_id', '!=', $advert->user_id)
            ->each(function($subscription) use ($advert) {
                $subscription->user->notify(new AdvertWasAdded($advert->city, $advert));
            });

        Mail::to($advert->user)->send(new AdvertCreatedConfirmationMail());
    }

    /**
     * Update slug if title changed but slug didn't.
     *
     * @param  \App\Advert  $advert
     * @return void
     */
    public function updated(Advert $advert)
    {
        if($advert->isDirty('title') && $advert->isClean('slug')) $advert->update(['slug' => $advert->title]);
    }
}
