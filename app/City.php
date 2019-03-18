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
     * Generate a url.
     * 
     * @return string
     */
    public function path($admin = false) 
    {
        return ($admin) ? "/admin/{$this->name}" : '/'.$this->name;
    }

    /**
     * Define eloquent relationship between city and adverts.
     * 
     * @return Collection [Advert]
     */
    public function adverts() 
    {
        return $this->hasMany(Advert::class);
    }
}
