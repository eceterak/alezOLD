<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Advert;

class AdvertsRevisionController extends Controller
{
    /**
     * Accept a changes to advert.
     * 
     * @return
     */
    public function store(Advert $advert) 
    {
        $advert->acceptRevision();

        return redirect()->route('admin.adverts.edit', $advert->slug);
    }

    /**
     * Reject a changes to advert.
     * 
     * @return
     */
    public function destroy(Advert $advert) 
    {
        $advert->rejectRevision();

        return redirect()->route('admin.adverts.edit', $advert->slug);
    }
}
