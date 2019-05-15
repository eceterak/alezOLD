<?php

namespace App\Observers;

use App\Advert;
use App\Notifications\AdvertWasAdded;

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
        $advert->generateSlug();

        $advert->city->subscriptions
            ->where('user_id', '!=', $advert->user_id)
            ->each(function($subscription) use ($advert) {
                $subscription->user->notify(new AdvertWasAdded($advert->city, $advert));
            });

        // OR

        //CitySubscription::where('city_id', $advert->city->id)->each->notify(new AdvertWasAdded);
    }

    /**
     * Update slug if title changed but slug didn't.
     *
     * @param  \App\Advert  $advert
     * @return void
     */
    public function updated(Advert $advert)
    {
        if($advert->isDirty('title') && $advert->isClean('slug')) $advert->generateSlug();
    }
}
