<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    /**
     * Eager the advert.
     * 
     * @var array
     */
    protected $with = [
        'advert'
    ];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * It belongs to Advert.
     * 
     * @return App\Advert
     */
    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }
}
