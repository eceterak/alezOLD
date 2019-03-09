<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Advert;

class City extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * 
     * 
     * @return
    */
    public function path() 
    {
        return '/'.$this->name;
    }

    /**
     * 
     * 
     * @return
    */
    public function adverts() 
    {
        return $this->hasMany(Advert::class);
    }
}
