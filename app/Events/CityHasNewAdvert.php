<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class CityHasNewAdvert
{
    use SerializesModels;

    /**
     * @var App\City
     */
    public $city;

    /**
     * @var App\Advert
     */
    public $advert;

    /**
     * Create a new notification instance.
     * 
     * @param City $city
     * @param Advert $advert
     * @return void
     */
    public function __construct($city, $advert)
    {
        $this->city = $city;
        $this->advert = $advert;
    }
}
