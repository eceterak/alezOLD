<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Room;

class City extends Model
{
    protected $guarded = [];

    /**
     * Define eloquent relationship between city and rooms.
     * 
     * @return Collection App\Room
     */
    public function rooms() 
    {
        return $this->hasMany(Room::class);
    }

    /**
     * City can have many streets.
     * 
     * @return Collection App\Street
     */
    public function streets() 
    {
        return $this->hasMany(Street::class);
    }

    /**
     * Populate html form.
     * 
     * @return array
     */
    static public function form() 
    {
        return self::pluck('name', 'id');
    }

    /**
     * Transform title into SEO friendly url.
     * 
     * @return string
     */
    public function path() 
    {
        return preparePath($this->name);
    }

    /**
     * Find and return an instance of city, by its path.
     * 
     * @return App\City
     */
    static public function getByPath($path) 
    {
        return self::where('name', parsePath($path))->firstOrFail();
    }
}
