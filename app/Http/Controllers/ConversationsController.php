<?php

namespace App\Http\Controllers;
use App\Conversation;

use Illuminate\Http\Request;
use App\Http\Requests\ConversationRequest;
use App\Advert;

class ConversationsController extends Controller
{

    /**
     * Show inbox.
     * 
     * @refactor should be inbox / sent
     * @return view
     */
    public function index() 
    {
        return view('conversations.index')->with([
            'profile' => $user = auth()->user(),
            'conversations' => $user->inbox
        ]);
    }

    /**
     * Display a single conversation between two users.
     * 
     * @return view
     */
    public function show(Conversation $conversation) 
    {
        $this->authorize('view', $conversation);

        // User read the conversation so it wont be 'bolded'.
        auth()->user()->read($conversation);

        return view('conversations.show')->with([
            'conversation' => $conversation
        ]);
    }

    /**
     * @Refactor - it should be in MessagesController
     * @refactor - I dont need ConversationRequest
     * 
     * @param Request $request
     * @return redirect
     */
    public function reply(Conversation $conversation, ConversationRequest $request) 
    {
        $request->validate([
            'body' => 'required'
        ]);

        $conversation->reply($request->body);

        return redirect()->back();
    }

    /**
     * Start a new conversation.
     * 
     * @param $city
     * @param Advert $advert
     * @return redirect
     */
    public function store($city, Advert $advert) 
    {
        $advert->inquiry(request()->body);

        return redirect()->back();
    }
}
