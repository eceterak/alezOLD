<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Advert;

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
     * Replace default key for route model binding.
     * 
     * @return string
     */
    public function getRouteKeyName() 
    {
        return 'slug';
    }

    /**
     * Define eloquent relationship between city and adverts.
     * 
     * @return Collection App\Advert
     */
    public function adverts() 
    {
        return $this->hasMany(Advert::class);
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
