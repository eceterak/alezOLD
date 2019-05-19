<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Checks if user can update given profile.
     * 
     * @param User $user
     * @param Advert $advert
     * @return bool
     */
    public function update(User $signedInUser, User $user) 
    {
        return $signedInUser->is($user);
    }
}
