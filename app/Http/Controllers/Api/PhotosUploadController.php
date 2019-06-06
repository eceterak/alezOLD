<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Advert;

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
            'url' => $photo->url
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

    /**
     * Add another photo to existing advert.
     * 
     * @param Advert $advert
     * @return response
     */
    public function update(Advert $advert) 
    {
        request()->validate([
            'photo' => 'required|image|max:1000'
        ]);

        $photo = $advert->photos()->create([
            'url' => request()->file('photo')->store('photos', 'public'),
            'order' => ($advert->photos()->max('order') + 1)
        ]);

        return response()->json([
            'id' => $photo->id,
            'url' => $photo->url
        ]);
    }
}
