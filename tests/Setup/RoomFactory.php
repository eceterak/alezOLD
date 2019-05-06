<?php

namespace Tests\Setup;

use Facades\Tests\Setup\StreetFactory;
use App\Street;
use App\City;
use App\Room;
use App\User;

class RoomFactory 
{

    protected $user = null;

    protected $city = null;

    protected $street = null;

    /**
     * Associate room with a user.
     * 
     * @return this
     */
    public function ownedBy(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Room can belong to a city.
     * 
     * @return this
     */
    public function belongsTo(City $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Rooms street.
     * 
     * @return this
     */
    public function street(Street $street)
    {
        $this->street = $street;
        $this->city = $street->city;

        return $this;
    }

    /**
     * Create a new instance of Room.
     * 
     * @return Room
     */
    public function create() 
    {
        $street = ($this->street) ? $this->street : StreetFactory::create();

        $room = factory(Room::class)->create([
            'user_id' => $this->user ?? factory(User::class),
            'city_id' => $this->city ?? $street->city->id,
            'street_id' => $this->street ?? $street->id
        ]);

        $this->street = null;
        $this->city = null;

        return $room;
    }

    /**
     * Return a instance of a Room object without saving it to a database.
     * 
     * @return App\Room
     */
    public function raw() 
    {
        $street = StreetFactory::create();

        $room = factory(Room::class)->raw([
            'user_id' => $this->user ?? factory(User::class),
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ]);

        return $room;
    }
}