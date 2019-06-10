<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'featured' => 'boolean'
    ];

    /**
     * Photo belongs to advert.
     * Useful when having access to single photo and wanting to get all sibilings trough advert.
     * 
     * @return App\Advert
     */
    public function advert() 
    {
        return $this->belongsTo(Advert::class);
    }
}
