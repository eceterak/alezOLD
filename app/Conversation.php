<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @array
     */
    protected $with = [
        'sender', 'receiver'
    ];

    /**
     * Get all messages sorted by date.
     * 
     * @return App\Message
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    /**
     * Get a user who received a message.
     * 
     * @return App\User
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Get a user who sent a message.
     * 
     * @return App\User
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get an advert associated with a message.
     * 
     * @return App\User
     */
    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }

    /**
     * Send a message to reply.
     * 
     * @param string $body
     * @return void
     */
    public function reply($body) 
    {
        $this->messages()->create([
            'user_id' => auth()->user()->id,
            'body' => $body
        ]);
    }

    /**
     * Check if conversation has a unread messages for a authenticated user.
     * 
     * @return bool
     */
    public function hasNewMessagesFor() 
    {
        $key = auth()->user()->visitedConversationCacheKey($this);

        return !! $this->updated_at > cache($key);
    }
}
