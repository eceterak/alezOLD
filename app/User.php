<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
    protected $hidden = [
        'password', 'remember_token',
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
     * User can have many rooms.
     *
     * @return Collection
     */
    public function rooms() 
    {
        return $this->hasMany(Room::class);
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
        return $this->inbox->merge($this->sent);
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
