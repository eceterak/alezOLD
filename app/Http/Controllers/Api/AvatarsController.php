<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AvatarsController extends Controller
{
    /**
     * Upload new Avatar.
     * Delete old one if present.
     * 
     * @return response
     */
    public function store() 
    {
        request()->validate([
            'avatar' => 'required|image|max:200'
        ]);

        auth()->user()->deleteAvatar();

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return response([], 204);
    }

    /**
     * Remove avatar of authenticated user.
     * 
     * @return response
     */
    public function destroy() 
    {
        auth()->user()->deleteAvatar();

        return response([], 204);
    }
}
