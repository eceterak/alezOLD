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
     * @var array
     */
    protected $touches = ['conversation'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // @refactor :>
        static::created(function($message)
        {
            if($message->conversation->sender->id !== $message->user_id)
            {
                $message->conversation->sender->notify(new YouHaveANewMessage($message->conversation));
            }
            else
            {
                $message->conversation->receiver->notify(new YouHaveANewMessage($message->conversation));
            }
        });
    }

    /**
     * 
     * 
     * @return App\Conversation
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get
     * 
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
