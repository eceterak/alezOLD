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
            'avatar' => 'required|image|max:400'
        ]);

        auth()->user()->deleteAvatar();

        auth()->user()->update([
            'avatar_path' => $url = request()->file('avatar')->store('avatars', 'public')
        ]);

        return response()->json([
            'url' => $url
        ]);
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
