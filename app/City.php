<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Room;

class City extends Model
{
    protected $guarded = [];

    /**
     * Set default attributes.
     * 
     * @var array
     */
    protected $attributes = [
        'slug' => '',
        'suggested' => 0
    ];

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
        return $this->hasMany(Street::class)->orderBy('name');
    }

    /**
     * Add a new street.
     * 
     * @param array $attributes
     * @return bool
     */
    public function addStreet($attributes) 
    {
        return $this->streets()->create($attributes);
    }

    /**
     * Create a slug from name.
     * 
     * @return void
     */
    public function createSlug() 
    {
        $this->update([
            'slug' => str_slug($this->name)
        ]);
    }

    /**
     * Find and return an instance of city, by its unique slug.
     * 
     * @param string $slug.
     * @return App\City
     */
    static public function getBySlug($slug) 
    {
        return self::where('slug', $slug)->firstOrFail();
    }
}
