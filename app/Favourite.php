<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;

class Favourite extends Model
{
    use RecordsActivity;

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
