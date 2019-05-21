<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
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
        static::addGlobalScope('advertCount', function($builder) {
            $builder->withCount('adverts');
        });


        static::created(function($city) {
            $city->generateSlug();
        });

        static::deleting(function($city) {
            $city->adverts->each->delete(); // Be careful about this!
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
     * 
     * 
     * @return
     */
    public function toSearchableArray() 
    {
        return [
            'name' => $this->name
        ];
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
     * City has many subscribers.
     * 
     * @return App\CitySubscription
     */
    public function subscriptions() 
    {
        return $this->hasMany(CitySubscription::class);
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
     * Generate a slug.
     * 
     * @return void
     */
    public function generateSlug() 
    {
        //$no = City::where('name', $this->name); // Refactor, cities with same name must include unique number.

        $this->update([
            'slug' => str_slug($this->name)
        ]);
    }

    /**
     * Subscribe to a city.
     * 
     * @return this
     */
    public function subscribe() 
    {
        $this->subscriptions()->create([
            'user_id' => auth()->id()
        ]);

        return $this;
    }

    /**
     * Unsubscribe from a city.
     * 
     * @return void
     */
    public function unsubscribe() 
    {
        $this->subscriptions()->where('user_id', auth()->id())->delete();
    }

    /**
     * Check if authenticated user is subscribing to a city.
     * 
     * @return bool
     */
    public function getIsSubscribedAttribute() 
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }
}
