<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\MessageException;

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
        return $this->hasMany(Message::class);
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
     * As conversation has always only two participants
     * and one of them is logged in, grab the second one who is the interlocutor.
     * 
     * @param App\User $user
     * @return App\User
     */
    public function interlocutor($user = null) 
    {
        $user = $user ?? auth()->user();

        return $this->users->except($user->id)[0];
    }

    /**
     * Register interlocutor as a custom property.
     * 
     * @return App\User
     */
    public function getInterlocutorAttribute() 
    {
        return $this->interlocutor();
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
     * @param App\User $user
     * @return void
     */
    public function reply($body, $user = null) 
    {
        $user = $user ?? auth()->user();

        $this->messages()->create([
            'user_id' => $user->id,
            'to_id' => $this->interlocutor($user)->id,
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

    /**
     * Check if both participants of a conversation are still active.
     * 
     * @return bool
     */
    public function areUsersActive() 
    {
        if($this->users()->where('active', false)->exists()) throw new MessageException('Nie udało się wysłać wiadomości. Możliwe, że konto rozmówcy zostało właśnie usunięte.');
    }

    /**
     * Fetch last 6 messages, and check if they are all belong to same, authenticated user.
     * If they are, it means that user is probably spamming.
     * 
     * @return Exception MessageException
     */
    public function messagingTooFrequently() 
    {
        $messages = $this->messages()->latest()->limit(6)->pluck('user_id');

        $check = $messages->count() > 5 && $messages->every(function($value) {
            return $value == auth()->id();
        });

        if($check) throw new MessageException('Too frequent');
    }
}