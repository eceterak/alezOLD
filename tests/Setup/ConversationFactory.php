<?php

namespace Tests\Setup;

use Facades\Tests\Setup\AdvertFactory;
use App\User;
use App\Message;

class ConversationFactory 
{    
    /**
     * @var int
     */
    protected $messageCount = null;

    /**
     * Set how many messages to generate within the conversation.
     * 
     * @return this
     */
    public function messageCount($count) 
    {
        $this->messageCount = $count;

        return $this;
    }

    /**
     * Create a new instance of App\Conversation.
     * 
     * @return App\Conversation
     */
    public function create() 
    {
        $advert = AdvertFactory::create();

        $user = auth()->user() ?? create(User::class);

        $conversation = $advert->inquiry('Testing', $user);

        if($this->messageCount)
        {
            create(Message::class, [
                'conversation_id' => $conversation->id,
                'user_id' => $user->id,
                'to_id' => $advert->user->id,
            ], $this->messageCount);
        }
        
        return $conversation;
    }
}