<?php

namespace App\Http\Controllers\Conversations;

use App\Http\Controllers\Controller;
use App\Conversation;
use App\Advert;
use Illuminate\Support\Facades\Gate;

class ConversationsController extends Controller
{
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

        auth()->user()->sawNotificationsFor($conversation);

        return view('users.conversations.show')->with([
            'conversation' => $conversation
        ]);
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
        try 
        {
            $this->authorize('inquiry', $advert);
        }
        catch(\Exception $e)
        {
            return back()->withErrors(['self' => 'To ogłoszenie należy od Ciebie ;)']);
        }
        
        $advert->inquiry(request()->body);

        return redirect()->back()->with('flash', 'Wiadomość została wysłana');
    }
}
