<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'validated' => false,
        'active' => false
    ];

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
     * Define eloquent relationship between street and Room.
     * 
     * @return App\City
     */

    public function street()
    {
        return $this->belongsTo(Street::class);
    }

    /**
     * Return a portion of a title.
     * 
     * @return string
     */
    public function shortTitle() 
    {
        return str_limit($this->title, 20, '...');
    }

    /**
     * Scope to get access to QueryBuilder.
     * 
     * @param $query
     * @param QueryFilter $filters
     * 
     * @return
     */
    public function scopeFilter($query, QueryFilter $filters) 
    {
        return $filters->apply($query);
    }

    /**
     * Get the instance of a Room.
     * 
     * @param string $slug
     * @return App\Room
     */
    static public function getBySlug($slug)
    {
        $id = substr($slug, strrpos($slug, '-uid-') + 5); // get last occurence of uid.

        return self::where('id', intval($id, 36))->firstOrFail();
    }
    
    /**
     * Generate a slug after new room is added to a database (it uses a id).
     * 
     * @return void
     */
    public function generateSlug() 
    {
        $slug = str_slug($this->title.'-uid-'.$this->encodeId());

        $this->update([
            'slug' => $slug
        ]);
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