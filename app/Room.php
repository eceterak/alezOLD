<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    /**
     * Define eloquent relationship between user and Room.
     * 
     * @return App\User
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define eloquent relationship between city and Room.
     * 
     * @return App\City
     */

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the instance of a Room.
     * 
     * @param string $path
     * @return Room
     */
    static public function getByPath($path)
    {
        $id = substr($path, strrpos($path, '-uid-') + 5); // get last occurence of uid.

        return self::where('id', intval($id, 36))->firstOrFail();
    }
    
    /**
     * Treansform title into SEO friendly url. 
     * Replace spaces with dashes and add encoded id at the end.
     * 
     * @return string
     */
    public function path() 
    {
        return preparePath($this->title).'-uid-'.$this->encodeId();
    }

    /**
     * Encode id.
     * 
     * @return string
     */
    public function encodeId() 
    {
        return base_convert($this->id, 10, 36);
    }
}