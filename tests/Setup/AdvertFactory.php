<?php

namespace Tests\Setup;

use App\Street;
use App\City;
use App\Advert;
use App\User;

class AdvertFactory 
{

    /**
     * @var App\User
     */
    protected $user = null;

    /**
     * @var App\City
     */
    protected $city = null;

    /**
     * @var App\Street
     */
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
     * City.
     * 
     * @return this
     */
    public function city(City $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Street.
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
     * @param array $data
     * @param int $amount
     * @return App\Advert
     */
    public function create($data = [], $amount = 1) 
    {
        return $this->make('create', $data, $amount);
    }

    /**
     * Return an array.
     * 
     * @param array $data
     * @param int $amount
     * @return array
     */
    public function raw($data = [], $amount = 1) 
    {
        return $this->make('raw', $data, $amount);
    }
    
    /**
     * 
     * 
     * @param string $method
     * @param array $data
     * @param int $amount
     * @return mixed
     */
    public function make($method = 'create', $data, $amount = 1) 
    {
        $street = ($this->street) ? $this->street : create(Street::class);

        $attributes = array_merge([
            'user_id' => $this->user ?? create(User::class),
            'city_id' => $this->city ?? $street->city->id,
            'street_id' => $this->street ?? $street->id,
            'verified' => true
        ], $data);

        $this->city = null;
        $this->street = null;
        $this->user = null;

        return $amount == 1 ? factory(Advert::class)->{$method}($attributes) : factory(Advert::class, $amount)->{$method}($attributes);
    }
}