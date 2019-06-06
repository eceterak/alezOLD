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
        'user'
    ];
    
    /**
     * Register custom attributes.
     * 
     * @var array
     */
    protected $appends = [
        'isFavourited', 'FeaturedPhotoPath'
    ];

    /**
     * Casts from database to model.
     * 
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
        'archived' => 'boolean',
        'revision' => 'array'
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
     * Get photos.
     * 
     * @return App\Photo
     */
    public function photos() 
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Display additional info if advert is deleted (archived).
     * 
     * @return string
     */
    public function getTitleAttribute($title) 
    {
        return ($this->archived) ? $title.' (zakończone)' : $title;
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
            'verified' => true
        ]);

        //$this->recordActivity('verified_advert');

        return $this;
    }

    /**
     * Archive an advert.
     * 
     * @return this
     */
    public function archive() 
    {
        $this->update([
            'archived' => true
        ]);

        //$this->recordActivity('deleted_advert');

        return $this;
    }

    /**
     * Send an inquiry about the advert.
     * 
     * @param string $body
     * @param App\User $user
     * @return App\Conversation
     */
    public function inquiry($body, $user = null) 
    {
        $user = ($user) ?? auth()->user();

        $conversation = $this->conversations()->create();

        // Update the conversation_user pivot table.
        $conversation->users()->sync([$user->id, $this->user->id]);

        // Send a message.
        $conversation->reply($body, $this, $user);

        return $conversation;
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
            $slug = $slug.'-'.substr(md5(now()), 0, 3).str_random(2);
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

    /**
     * Get the path to the featured photo if any found.
     * 
     * @return string
     */
    public function getFeaturedPhotoPathAttribute() 
    {
        $featured = $this->photos()->where('order', 0)->first();

        return ($featured) ? 'https://alez.s3.eu-central-1.amazonaws.com/'.$featured->url : '/storage/photos/notfound.jpg';
    }

    /**
     * Register has_pending_revision attribute.
     * 
     * @return bool
     */
    public function getHasPendingRevisionAttribute() 
    {
        return ! empty($this->revision);
    }

    /**
     * Check if there are any unsaved (unverified) changes to the model and update the model.
     * 
     * @return $this
     */
    public function loadPendingRevision() 
    {
        if($this->has_pending_revision)
        {
            foreach($this->revision as $key => $value)
            {
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    /**
     * Accept revision.
     * 
     * @return void
     */
    public function acceptRevision() 
    {
        $this->loadPendingRevision()->save();
    }
}