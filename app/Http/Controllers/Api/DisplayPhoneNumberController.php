<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Advert;

class DisplayPhoneNumberController extends Controller
{
    /**
     * Return a full phone number. 
     * Phone number is hidden by default for privacy reasons.
     * 
     * @param Advert $advert
     * @return json
     */
    public function show(Advert $advert) 
    {
        return response()->json([
            'phone' => wordwrap($advert->phone, 3, ' ', true)
        ]);
    }
}
