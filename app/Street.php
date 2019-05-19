<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $guarded = [];

    /**
     * It belongs to a city.
     * 
     * @return App\City
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
