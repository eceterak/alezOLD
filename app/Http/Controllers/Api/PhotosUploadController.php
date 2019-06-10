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
     * @return json
     */
    public function store() 
    {
        request()->validate([
            'photo' => 'required|image|max:1000'
        ]);

        $photo = Photo::create([
            'url' => request()->file('photo')->store('photos', 's3')
        ]);

        return response()->json([
            'id' => $photo->id,
            'url' => $photo->url
        ]);
    }

    /**
     * Remove a file from disk and a record from database.
     * 
     * @return response
     */
    public function destroy(Photo $photo) 
    {
        if($photo->advert) 
        {
            $this->authorize('update', $photo->advert);

            $photo->advert->photos()->where('order', '>', $photo->order)->each(function($photo) {
                $photo->update([
                    'order' => $photo->order - 1
                ]);
            });
        }

        Storage::disk('s3')->delete($photo->url);

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
        $this->authorize('update', $advert);

        request()->validate([
            'photo' => 'required|image|max:1000'
        ]);

        if($advert->photos()->exists()) $order = $advert->photos()->max('order') + 1;

        $photo = $advert->photos()->create([
            'url' => request()->file('photo')->store('photos', 's3'),
            'order' => (isset($order)) ? $order : 0
        ]);

        return response()->json([
            'id' => $photo->id,
            'url' => $photo->url
        ]);
    }
}
