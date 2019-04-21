<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $guarded = [];

    public function path()
    {
        return preparePath($this->name);
    }

    /**
     * Get instance of a street by a path.
     * 
     * @return App\Street
     */
    static public function getByPath($city, $street) 
    {
        $city = City::getByPath($city);

        return Street::where('name', parsePath($street))->where('city_id', $city->id)->first();
    }

    /**
     * Street belongs to a city.
     * 
     * @return App\City
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
