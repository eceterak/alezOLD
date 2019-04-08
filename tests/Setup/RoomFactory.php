<?php

namespace Tests\Setup;

use App\City;
use App\Room;
use App\User;

class RoomFactory 
{

    protected $user = null;

    /**
     * Associate room with a user.
     * 
     * @return this
     */
    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Create a new instance of Room.
     * 
     * @return Room
     */
    public function create() 
    {
        $city = factory(City::class)->create();

        $room = factory(Room::class)->create([
            'user_id' => $this->user ?? factory(User::class),
            'city_id' => $city->id
        ]);

        return $room;
    }
}