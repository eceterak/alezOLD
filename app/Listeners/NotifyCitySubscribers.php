<?php

namespace App\Listeners;

use App\Events\CityHasNewAdvert;
use App\Notifications\AdvertWasAdded;

class NotifyCitySubscribers
{
    /**
     * Notify subscribers about a new Advert.
     *
     * @param  CityHasNewAdvert  $event
     * @return void
     */
    public function handle(CityHasNewAdvert $event)
    {    
        $event->city->subscriptions
            ->where('user_id', '!=', $event->advert->user_id)
            ->each(function($subscription) use($event) {
                $subscription->user->notify(new AdvertWasAdded($event->city, $event->advert));
            });
    }
}
