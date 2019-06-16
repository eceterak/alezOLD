<?php

namespace App\Traits;

use App\CitySubscription;

trait Subscribable 
{
    /**
     * City has many subscribers.
     * 
     * @return App\CitySubscription
     */
    public function subscriptions() 
    {
        return $this->hasMany(CitySubscription::class);
    }

    /**
     * Subscribe to a city.
     * 
     * @param App\User $user
     * @return this
     */
    public function subscribe($user = null) 
    {
        return $this->subscriptions()->create([
            'user_id' => $user->id ?? auth()->id()
        ]);
    }

    /**
     * Unsubscribe from a city.
     * 
     * @return void
     */
    public function unsubscribe() 
    {
        $this->subscriptions()->where('user_id', auth()->id())->delete();
    }

    /**
     * Check if authenticated user is subscribing to a city.
     * 
     * @return bool
     */
    public function getIsSubscribedAttribute() 
    {
        return (bool) (auth()->user()) ? $this->subscriptions()->where('user_id', auth()->id())->exists() : false;
    }
}