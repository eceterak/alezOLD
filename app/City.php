<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Room;

class City extends Model
{
    protected $fillable = [
        'name',
        'suggested'
    ];

    /**
     * Define eloquent relationship between city and rooms.
     * 
     * @return Collection [Room]
     */
    public function rooms() 
    {
        return $this->hasMany(Room::class);
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
}
