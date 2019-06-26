<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Advert;

class AdvertsVerificationController extends Controller
{
    /**
     * Verify an advert.
     * 
     * @return response
     */
    public function store(Advert $advert) 
    {
        $advert->verify();

        if($advert->photos->count())
        {
            $advert->photos()->update([
                'verified' => true
            ]);
        }

        return response()->json([
            'message' => 'Ogłoszenie zweryfikowane'
        ], 200);
    }
}