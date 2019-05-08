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
    public function update(User $user, Advert $advert) 
    {
        return $user->is($advert->user);
    }
}
