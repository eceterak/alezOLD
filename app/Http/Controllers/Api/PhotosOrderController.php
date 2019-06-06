<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Advert;

class PhotosOrderController extends Controller
{

    /**
     * Add another photo to existing advert.
     * Search for photos in a model so user wont update the order
     * of someone elses photos.
     * 
     * @param Advert $advert
     * @return response
     */
    public function update(Advert $advert) 
    {
        $this->authorize('update', $advert);
        
        $photos = explode(',', request('photos'));
        
        foreach($photos as $key => $id)
        {
            $photo = $advert->photos()->find($id);

            if($photo)
            {
                $photo->update([
                    'order' => $key
                ]);
            }
        }

        return response('Kolejność zdjęć zmieniona', 204);
    }
}
