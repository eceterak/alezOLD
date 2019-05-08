<?php

namespace App\Observers;

use App\TemporaryAdvert;

class TemporaryAdvertObserver
{
    /**
     * Generate a token when creating a new room.
     * 
     * @param  \App\TemporaryAdvert $advert
     * @return void
     */
    public function creating(TemporaryAdvert $temporary)
    {
        $temporary->generateToken();
    }
}
