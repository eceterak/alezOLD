<?php

namespace App\Http\Controllers;
use App\Conversation;

use Illuminate\Http\Request;
use App\Advert;
use App\Http\Requests\ConversationRequest;

class ConversationsController extends Controller
{

    /**
     * Show inbox.
     * 
     * @return view
     */
    public function inbox() 
    {
        return view('conversations.index');
    }

    /**
     * 
     * 
     * @return
     */
    public function show(Conversation $conversation) 
    {
        $this->authorize('view', $conversation);

        return view('conversations.show')->with([
            'conversation' => $conversation
        ]);
    }

    /**
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
     * @param Request $request
     * @return redirect
     */
    public function store($city, $slug, Request $request) 
    {
        $advert = Advert::getBySlug($slug);

        $advert->inquiry($request->body);

        return redirect()->back();
    }
}
