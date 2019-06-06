<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\YouHaveANewMessage;

class Message extends Model
{    
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Touch the conversation, to update the timestamps.
     * Use it to define if user read all messages from given conversation.
     * 
     * @var array
     */
    protected $touches = ['conversation'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function($message)
        {
            $message->receiver->notify(new YouHaveANewMessage($message->conversation));
        });
    }

    /**
     * Get the conversation.
     * 
     * @return App\Conversation
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get a user who sent a message.
     * 
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 
     * 
     * @return
     */
    public function receiver() 
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
