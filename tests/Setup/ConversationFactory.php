<?php

namespace Tests\Setup;

use Facades\Tests\Setup\AdvertFactory;
use App\User;

class ConversationFactory 
{    
    /**
     * Create a new instance of App\Conversation.
     * 
     * @return App\Conversation
     */
    public function create() 
    {
        $advert = AdvertFactory::create();

        $user = auth()->user() ?? create(User::class);
        
        return $advert->inquiry('Testing', $user);
    }
}