<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id', 'name', 'role', 'avatar_path'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Replace default key for route model binding.
     * 
     * @return string
     */
    public function getRouteKeyName() 
    {
        return 'name';
    }

    /**
     * User has many adverts.
     *
     * @return Collection
     */
    public function adverts() 
    {
        return $this->hasMany(Advert::class)->latest();
    }

    /**
     * Get all received conversations.
     * 
     * @return App\Conversation
     */
    public function inbox() 
    {
        return $this->hasMany(Conversation::class, 'receiver_id')->latest();
    }

    /**
     * Get all sent conversations.
     * 
     * @return App\Conversation
     */
    public function sent()
    {
        return $this->hasMany(Conversation::class, 'sender_id');
    }

    /**
     * Return all conversations (both started and received).
     * 
     * @return Collection
     */
    public function conversations() 
    {
        return Conversation::where('sender_id', $this->id)->orWhere('receiver_id', $this->id)->get();
    }

    /**
     * User has many activities.
     * 
     * @return App\Activity
     */
    public function activities() 
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get all messages.
     * 
     * @return App\Conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get latest Advert that belongs to user.
     * 
     * @return App\Advert
     */
    public function lastAdvert()
    {
        return $this->hasOne(Advert::class)->latest();
    }

    /**
     * Check if user has admin privileges.
     * 
     * @return bool
     */
    public function isAdmin() 
    {
        return $this->role === 1;
    }

    /**
     * Return a path to avatar or default image if user has not uploaded one.
     * 
     * @return string
     */
    public function getAvatarPathAttribute($avatar_path) 
    {
        return (!is_null($avatar_path)) ? '/storage/'.$avatar_path : '/storage/avatars/notfound.png';
    }

    /**
     * User read the conversation.
     * 
     * @param App\Conversation $conversation
     * @return void
     */
    public function read($conversation) 
    {
        cache()->forever($this->visitedConversationCacheKey($conversation), Carbon::now());
    }

    /**
     * Return a cache key for visited conversation.
     * 
     * @param App\Conversation $conversation
     * @return string
     */
    public function visitedConversationCacheKey($conversation) 
    {
        return sprintf("users.%d.visits.%d", $this->id, $conversation->id);
    }
}
