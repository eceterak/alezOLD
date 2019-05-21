<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;
use App\Traits\RecordsActivity;
use App\Traits\Favouritable;
use Carbon\Carbon;

class Advert extends Model
{
    use RecordsActivity, Favouritable;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Eager load city, user and favourites.
     * 
     * @var array
     */
    protected $with = [
        'city',
        'user', 
        'favourites'
    ];

    /**
     * Default attributes.
     * 
     * @var array
     */
    protected $attributes = [
        'verified' => false,
        'active' => false
    ];

    /**
     * Register custom attributes.
     * 
     * @var array
     */
    protected $appends = [
        'isFavourited'
    ];

    /**
     * Casts from database to model.
     * 
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
        'active' => 'boolean'
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
     * Advert belongs to user.
     * 
     * @return App\User
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Advert belongs to city.
     * 
     * @return App\City
     */

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Advert belongs to street.
     * 
     * @return App\City
     */

    public function street()
    {
        return $this->belongsTo(Street::class);
    }

    /**
     * Advert can have many conversations.
     * 
     * @return App\Conversation
     */
    public function conversations() 
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * 
     * 
     * @return App\Photo
     */
    public function photos() 
    {
        return $this->hasMany(Photo::class);
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
     * @return QueryFilters
     */
    public function scopeFilter($query, QueryFilter $filters) 
    {
        return $filters->apply($query);
    }

    /**
     * Verify an advert.
     * 
     * @return this
     */
    public function verify() 
    {
        $this->update([
            'verified' => true,
            'active' => true
        ]);

        $this->recordActivity('verified_advert');

        return $this;
    }

    /**
     * Send an inquiry about the advert.
     * 
     * @refactor
     * @param string $body
     * @return void
     */
    public function inquiry($body) 
    {
        $conversation = $this->conversations()->create([
            'receiver_id' => $this->user->id,
            'sender_id' => auth()->user()->id
        ]); 

        // Conversation should be responsible for creating a new message?

        auth()->user()->messages()->create([
            'conversation_id' => $conversation->id,
            'body' => $body
        ]);
    }

    /**
     * Set a unique slug based on the title and id.
     * 
     * @param string $title
     */
    public function setSlugAttribute($title) 
    {
        $slug = str_slug($title);

        if(static::where('slug', $slug)->exists())
        {
            $slug = $slug.'-'.$this->id;
        }

        $this->attributes['slug'] = $slug;
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

    /**
     * Check if advert was published within the last minute.
     * 
     * @return boolean
     */
    public function wasJustPublished() 
    {
        // gt stands for Greater Than, subMinute, substracts a minute from current time.
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

}