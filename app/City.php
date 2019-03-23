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
     * Generate a frontend url.
     * 
     * @return string
     */
    public function path() 
    {
        return '/'.preparePath($this->name);
    }

    /**
     * Generate a backend url.
     * 
     * @return string
     */
    public function adminPath() 
    {
        return '/admin/'.preparePath($this->name).'/edytuj';
    }

    /**
     * Define eloquent relationship between city and rooms.
     * 
     * @return Collection [Room]
     */
    public function rooms() 
    {
        return $this->hasMany(Room::class);
    }
}
