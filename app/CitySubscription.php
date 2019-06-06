<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitySubscription extends Model
{
    protected $guarded = [];

    /**
     * Eager load city.
     * 
     * @var array
     */
    protected $with = ['city'];

    /**
     * It belongs to an user.
     * 
     * @return App\User
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * It belongs to a city.
     * 
     * @return App\City
     */
    public function city() 
    {
        return $this->belongsTo(City::class);
    }
}
