<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Advert;

class AdvertPolicy
{
    use HandlesAuthorization;


    /**
     * Checks if given user can manage a Advert.
     * 
     * @param User $user
     * @param Advert $advert
     * @return bool
     */
    public function view(User $user = null, Advert $advert) 
    {
        if($user && $user->is($advert->user)) return true;
        
        return $advert->verified;
    }

    /**
     * Checks if given user can manage a Advert.
     * 
     * @param User $user
     * @param Advert $advert
     * @return bool
     */
    public function update(User $user, Advert $advert) 
    {
        return $user->is($advert->user);
    }

    /**
     * Checks if given user can manage a Advert.
     * 
     * @param User $user
     * @param Advert $advert
     * @return bool
     */
    public function create(User $user) 
    {            
        return (!is_null($user->fresh()->lastAdvert)) ? ! $user->lastAdvert->wasJustPublished() : true;
    }

    /**
     * Checks if user is not sending a message to himself.
     * 
     * @param User $user
     * @param Advert $advert
     * @return bool
     */
    public function inquiry(User $user, Advert $advert) 
    {            
        return ! $user->is($advert->user) && ! $advert->archived && $advert->verified;
    }
}
