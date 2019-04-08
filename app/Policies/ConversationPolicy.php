<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Conversation;

class ConversationPolicy
{
    use HandlesAuthorization;


    /**
     * 
     * 
     * @return
     */
    public function view(User $user, Conversation $conversation) 
    {
        return $user->is($conversation->sender) || $user->is($conversation->receiver);
        //return ($user->is($conversation->sender) || $user->is($conversation->receiver));
    }
}
