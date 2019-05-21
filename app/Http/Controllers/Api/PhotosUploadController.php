<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Photo;

class PhotosUploadController extends Controller
{
    /**
     * Upload a new photo and return its id and url.
     * 
     * @return response
     */
    public function store() 
    {
        request()->validate([
            'photo' => 'required|image|max:200'
        ]);

        $photo = Photo::create([
            'url' => request()->file('photo')->store('photos', 'public')
        ]);

        return response()->json([
            'id' => $photo->id,
            'url' => '/storage/'.$photo->url
        ]);
    }
}
