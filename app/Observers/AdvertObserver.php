<?php

namespace App\Observers;

use Illuminate\Support\Facades\Mail;
use App\Mail\AdvertCreatedConfirmationMail;
use App\Advert;
use App\User;
use App\Notifications\AdvertNeedsVerification;

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
        Mail::to($advert->user)->send(new AdvertCreatedConfirmationMail());

        User::where('role', 1)->get()->each(function($admin) use ($advert)
        {
            $admin->notify(new AdvertNeedsVerification($advert));
        });
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
