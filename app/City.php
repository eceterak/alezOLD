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
     * Register custom attributes.
     * 
     * @var array
     */
    protected $appends = [
        'isSubscribed'
    ];


    /**
     * Boot the model. Eager load the advert count.
     */
    protected static function boot() 
    {
        parent::boot();

        static::addGlobalScope('advertCount', function($builder) {
            $builder->withCount('adverts');
        });

        static::deleting(function($city) {
            $city->adverts->each->delete();
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
     * Many users can subscribe to a city.
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
     * Create a slug from name.
     * 
     * @return void
     */
    public function createSlug() 
    {
        $no = City::where('name', $this->name);

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
