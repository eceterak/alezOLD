<?php

namespace App\Http\Controllers\Conversations;

use App\Http\Controllers\Controller;
use App\Advert;

class AdvertConversationController extends Controller
{
    /**
     * Display all conversations for a given advert.
     * 
     * @param Advert $advert
     * @return view
     */
    public function show(Advert $advert) 
    {
        return view('users.conversations.advert')->with([
            'advert' => $advert,
            'profile' => auth()->user(),
            'conversations' => $advert->conversations
        ]);
    }
}
