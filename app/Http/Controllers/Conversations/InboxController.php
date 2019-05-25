<?php

namespace App\Http\Controllers\Conversations;

use App\Http\Controllers\Controller;

class InboxController extends Controller
{
    /**
     * Show inbox.
     * 
     * @return view
     */
    public function index() 
    {
        return view('users.conversations.inbox')->with([
            'profile' => $user = auth()->user(),
            'conversations' => auth()->user()->conversations()->whereHas('messages', function($query) use($user) {
                $query->where('user_id', '!=', $user->id);
            })->paginate()
        ]);
    }
}
