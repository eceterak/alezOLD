<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AvatarsController extends Controller
{
    /**
     * Upload new Avatar.
     * 
     * @return response
     */
    public function store() 
    {
        request()->validate([
            'avatar' => 'required|image|max:200'
        ]);

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return response([], 204);
    }
}
