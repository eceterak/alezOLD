<?php

namespace App\Http\Controllers;
use App\Conversation;

use Illuminate\Http\Request;
use App\Room;

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

    public function reply(Conversation $conversation) 
    {
        auth()->user()->messages()->create([
            'conversation_id' => $conversation->id,
            'body' => request('body')
        ]);

        return redirect()->back();
    }

    /**
     * Initialize a new conversation.
     * 
     * @return redirect
     */
    public function store($city, $room) 
    {
        $room = Room::getByPath($room);

        $conversation = auth()->user()->sent()->create([
            'room_id' => $room->id,
            'receiver_id' => $room->user->id
        ]);

        auth()->user()->messages()->create([
            'conversation_id' => $conversation->id,
            'body' => request('body')
        ]);

        return redirect()->back();
    }
}
