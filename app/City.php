<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
//use App\Traits\Subscribable;
use App\Advert;

class City extends Model
{
    use Searchable;

    /**
     * @var array
     */
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
     * Register custom attributes.
     * 
     * @var array
     */
    protected $appends = [
        'isSubscribed'
    ];

    /**
     * Boot the model.
     */
    protected static function boot() 
    {
        parent::boot();

        //Eager load the advert count.
        static::addGlobalScope('advertCount', function($builder) 
        {
            $builder->withCount('adverts');
        });

        static::created(function($city) 
        {
            $city->update(['slug' => $city->name]);
        });

        static::deleting(function($city) 
        {
            $city->adverts->each->delete(); // Be careful with this!
        });
    }

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
     * City has many adverts.
     * 
     * @return Collection App\Advert
     */
    public function adverts() 
    {
        return $this->hasMany(Advert::class)->latest();
    }

    /**
     * City has many streets.
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
     * Set a unique slug based on the name.
     * 
     * @param string $title
     */
    public function setSlugAttribute($name) 
    {
        $slug = str_slug($name);

        if(static::where('slug', $slug)->exists())
        {
            $slug = $slug.'-'.$this->id;
        }

        $this->attributes['slug'] = $slug;
    }
}
