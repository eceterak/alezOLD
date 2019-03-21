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
     * @param bool $admin
     * @return string
     */
    public function path($admin = false) 
    {
        $path = preparePath($this->name);

        return ($admin) ? "/admin/{$path}/edit" : '/'.$path;
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
