<?php

namespace App\Observers;

use App\Room;

class AdvertObserver
{
    /**
     * Record created activity and generate a slug.
     *
     * @param  \App\Room  $room
     * @return void
     */
    public function created(Room $room)
    {
        $room->generateSlug();
    }

    /**
     * Update slug if title changed but slug didn't.
     *
     * @param  \App\Room  $room
     * @return void
     */
    public function updated(Room $room)
    {
        if($room->isDirty('title') && $room->isClean('slug')) $room->generateSlug();
    }
}
