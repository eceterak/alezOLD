<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\RecordsActivity;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'name', 'role',
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
     * User can have many adverts.
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
        return $this->hasMany(Conversation::class, 'receiver_id');
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
     * Return all activities for the user.
     * 
     * @return App\Activity
     */
    public function activities() 
    {
        return $this->hasMAny(Activity::class);
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
     * Check if user has admin privileges.
     * 
     * @return bool
     */
     public function isAdmin() 
     {
        return $this->role === 1;
     }
}
