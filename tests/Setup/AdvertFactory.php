<?php

namespace Tests\Setup;

use Facades\Tests\Setup\StreetFactory;
use App\Street;
use App\City;
use App\Advert;
use App\User;

class AdvertFactory 
{

    protected $user = null;

    protected $city = null;

    protected $street = null;

    /**
     * Associate advert with a user.
     * 
     * @return this
     */
    public function ownedBy(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Advert can belong to a city.
     * 
     * @return this
     */
    public function belongsTo(City $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Adverts street.
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
     * Create a new instance of advert.
     * 
     * @return Advert
     */
    public function create() 
    {
        $street = ($this->street) ? $this->street : StreetFactory::create();

        $advert = factory(Advert::class)->create([
            'user_id' => $this->user ?? factory(User::class),
            'city_id' => $this->city ?? $street->city->id,
            'street_id' => $this->street ?? $street->id
        ]);

        $this->street = null;
        $this->city = null;

        return $advert;
    }

    /**
     * Return a instance of a advert object without saving it to a database.
     * 
     * @return App\Advert
     */
    public function raw() 
    {
        $street = StreetFactory::create();

        $room = factory(Advert::class)->raw([
            'user_id' => $this->user ?? factory(User::class),
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ]);

        return $room;
    }
}