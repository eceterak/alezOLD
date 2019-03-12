<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    /**
     * 
     */
    protected $fillable = [
        'user_id', 'city_id', 'title', 'description', 'rent'
    ];

    /**
     * 
     * 
     * @return
    */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * 
     */
    public function path() 
    {
        return "/pokoje/{$this->title}";
    }
}
