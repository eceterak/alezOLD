<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Room;

class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * 
     * 
     * @return
     */
    public function update(User $user, Room $room) 
    {
        return $user->is($room->user);
    }
}
