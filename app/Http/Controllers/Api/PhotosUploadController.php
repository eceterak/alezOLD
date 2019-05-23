<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Photo;
use Illuminate\Support\Facades\Storage;

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
            'photo' => 'required|image|max:1000'
        ]);

        $photo = Photo::create([
            'url' => request()->file('photo')->store('photos', 'public')
        ]);

        return response()->json([
            'id' => $photo->id,
            'url' => '/storage/'.$photo->url
        ]);
    }

    /**
     * Remove a file from storage and database.
     * 
     * @return response
     */
    public function destroy(Photo $photo) 
    {
        Storage::disk('public')->delete($photo->url);

        $photo->delete();

        return response(204);
    }
}
