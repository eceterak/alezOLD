<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Photo;
use App\Advert;

class PhotosVerificationController extends Controller
{
    /**
     * Photo is verified.
     * 
     * @param Photo $photo
     * @return response
     */
    public function store(Advert $advert) 
    {
        if($advert->photos->count())
        {
            $advert->photos()->update([
                'verified' => true
            ]);

            return response([
                'message' => 'Zdjęcia zweryfikowane'
            ], 200);
        }
    }

    /**
     * Photo is verified.
     * 
     * @param Photo $photo
     * @return response
     */
    public function update(Photo $photo) 
    {
        $photo->update([
            'verified' => true
        ]);

        return response([
            'message' => 'Zdjęcie zweryfikowane'
        ], 200);
    }
}
