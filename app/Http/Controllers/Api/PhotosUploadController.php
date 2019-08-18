<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Advert;
use App\Photo;

class PhotosUploadController extends Controller
{
    /**
     * As there no advert yet, we are using temp key to check how many adverts 
     * were added to the database already. If there is less than 7 of them,
     * upload a new photo and return its id and url so it can be displayed on frontend.
     * 
     * @param string $temp
     * @return json
     */
    public function store($temp) 
    {
        if(Photo::where('temp', $temp)->count() < 7)
        {
            $this->validateRequest();
    
            $photo = Photo::create([
                'url' => request()->file('photo')->store('photos', 's3'),
                'temp' => $temp
            ]);

            $response = [[
                'id' => $photo->id,
                'url' => $photo->url
            ], 200];
        }
        else
        {
            $response = [[
                'status' => 'error',
                'message' => 'Możesz dodać maksymalnie 7 zdjęć.'
            ], 500];
        }
        
        return response()->json(...$response);
    }

    /**
     * Remove a file from disk and a record from database.
     * 
     * @param string $temp
     * @return response
     */
    public function destroy(Photo $photo, $temp) 
    {
        if($photo->advert) 
        {
            $this->authorize('update', $photo->advert);

            $photo->advert->photos()->where('order', '>', $photo->order)->each(function($photo) {
                $photo->update([
                    'order' => $photo->order - 1
                ]);
            });
    
            Storage::disk('s3')->delete($photo->url);
    
            $photo->delete();
        }
        elseif($photo->temp == $temp)
        {            
            Storage::disk('s3')->delete($photo->url);
    
            $photo->delete();
        }
        else 
        {
            return response([
                'message' => 'Zdjęcie nie może zostać usunięte'
            ], 500);
        }

        return response([
            'message' => 'Zdjęcie usunięte'
        ], 200);
    }

    /**
     * Add another photo to existing advert.
     * Only 7 photos per advert are allowed.
     * 
     * @param Advert $advert
     * @return response
     */
    public function update(Advert $advert) 
    {
        $this->authorize('update', $advert);

        if($advert->photos->count() < 7) 
        {
            $this->validateRequest();
    
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
        else
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Możesz dodać maksymalnie 7 zdjęć.'
            ], 500);
        }
    }

    /**
     * Validate a request.
     * 
     * @return void
     */
    public function validateRequest() 
    {
        request()->validate([
            'photo' => 'required|image|max:4000'
        ]);        
    }
}
