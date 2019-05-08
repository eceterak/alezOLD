<?php

namespace App\Observers;

use App\Advert;

class AdvertObserver
{

    /**
     * Generate a slug when creating a new room.
     * 
     * @param  \App\Advert $advert
     * @return void
     */
    public function created(Advert $advert)
    {
        $advert->generateSlug();
    }

    /**
     * Update slug if title changed but slug didn't.
     *
     * @param  \App\Advert  $advert
     * @return void
     */
    public function updated(Advert $advert)
    {
        if($advert->isDirty('title') && $advert->isClean('slug')) $advert->generateSlug();
    }
}
