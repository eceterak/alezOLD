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
        $this->authorize('view', $conversation);

        request()->validate([
            'body' => 'required'
        ]);

        $conversation->reply(request()->body, $conversation->advert);

        return redirect()->back();
    }
}
