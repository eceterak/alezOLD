<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
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
     * Generate a url.
     * 
     * @param bool $admin
     * @return string
     */
    public function path($admin = false) 
    {
        $path = preparePath($this->title);

        return ($admin) ? '/admin/'.preparePath($this->city->name)."/{$path}/edytuj" : '/'.preparePath($this->city->name).'/'.$path;
    }
}
