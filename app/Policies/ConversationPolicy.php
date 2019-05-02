<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Conversation;
use App\User;

class ConversationPolicy
{
    use HandlesAuthorization;

    /**
     * 
     * @param User $user
     * @param Conversation $conversation
     * @return bool
     */
    public function view(User $user, Conversation $conversation) 
    {
        return $user->is($conversation->sender) || $user->is($conversation->receiver);
    }
}
