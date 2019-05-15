<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitySubscription extends Model
{
    protected $guarded = [];

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
     * It belongs to an city.
     * 
     * @return App\City
     */
    public function city() 
    {
        return $this->belongsTo(City::class);
    }
}
