<?php

namespace App\Http\Controllers\Conversations;

use App\Http\Controllers\Controller;
use App\Exceptions\MessageException;
use App\Conversation;

class MessagesController extends Controller
{
    /**
     * Before sending a message, check if both accounts are still active, 
     * authenticated user has a permision to view the conversation
     * and is not posting too frequently without an answer.
     * If any of checks fails, redirect catch custom Exception 
     * and redirect back with a message.
     * 
     * @param Request $request
     * @return redirect
     */
    public function store(Conversation $conversation) 
    {
        $this->authorize('view', $conversation);

        try 
        {
            $conversation->areUsersActive();

            $conversation->messagingTooFrequently();
        }
        catch(MessageException $e)
        {
            return redirect()->route('conversations.show', $conversation->id)->withErrors(['messageError' => $e->getMessage()]);
        }
        
        request()->validate([
            'body' => 'required|min:2|max:2000'
        ]);

        $conversation->reply(request()->body);    

        return redirect()->route('conversations.show', $conversation->id);
        
    }
}
