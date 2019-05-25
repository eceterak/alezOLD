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
     * Get an advert associated with a conversation.
     * 
     * @return App\Advert
     */
    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }
    /**
     * Get both of the users participating in the conversation.
     * 
     * @return
     */
    public function users() 
    {
        return $this->belongsToMany(User::class);
    }

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
     * Define who sent first message.
     * 
     * @return App\User
     */
    public function sender() 
    {
        return $this->messages()->first()->user;
    }

    /**
     * Register sender as a custom property.
     * 
     * @return App\User
     */
    public function getSenderAttribute() 
    {
        return $this->sender();
    }

    /**
     * Send a message.
     * 
     * @param string $body
     * @param App\Advert $advert
     * @param App\User $user
     * @return void
     */
    public function reply($body, $advert, $user = null) 
    {
        $user = $user ?? auth()->user();

        $this->messages()->create([
            'user_id' => $user->id,
            'to_id' => $advert->user->id,
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

        return $this->updated_at > cache($key);
    }
}
