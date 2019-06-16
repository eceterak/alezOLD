<?php

namespace App\Http\Controllers\Conversations;

use App\Http\Controllers\Controller;
use App\Conversation;

class MessagesController extends Controller
{
    /**
     * Send a message.
     * 
     * @param Request $request
     * @return redirect
     */
    public function store(Conversation $conversation) 
    {
        try 
        {
            $this->authorize('reply', $conversation);
        }
        catch(\Exception $e)
        {
            return redirect()->route('conversations.show', $conversation->id)->withErrors(['self' => 'Nie udało się wysłać wiadomości. Możliwe, że konto rozmówcy zostało właśnie usunięte.']);
        }

        request()->validate([
            'body' => 'required'
        ]);

        $conversation->reply(request()->body);    

        return redirect()->route('conversations.show', $conversation->id);
    }
}
