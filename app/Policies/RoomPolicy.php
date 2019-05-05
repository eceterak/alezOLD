<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Room;

class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * Checks if given user can manage a room.
     * 
     * @param User $user
     * @param Room $room
     * @return bool
     */
    public function update(User $user, Room $room) 
    {
        return $user->is($room->user);
    }
}
