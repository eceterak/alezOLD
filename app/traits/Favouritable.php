<?php

namespace App\Traits;

use App\Favourite;

trait Favouritable
{
    /**
     * Boot the trait.
     * 
     * @return void
     */
    public static function bootFavouritable() 
    {
        static::deleting(function($model) 
        {
            $model->favourites->each->delete();
        });
    }

    /**
     * Advert can have many conversations.
     * 
     * @return App\Favourite
     */
    public function favourites() 
    {
        return $this->hasMany(Favourite::class);
    }

    /**
     * @return this
     */
    public function favourite() 
    {
        $attributes = [
            'user_id' => auth()->user()->id
        ];

        if(!$this->favourites()->where($attributes)->exists()) 
        {
            return $this->favourites()->create($attributes);
        }
    }

    /**
     * @return void
     */
    public function unfavourite() 
    {
        $attributes = [
            'user_id' => auth()->user()->id
        ];

        if($this->favourites()->where($attributes)->exists()) 
        {
            $this->favourites()->get()->each->delete();
        }
    }

    /**
     * Check if advert is favourited by current user.
     * 
     * @return bool
     */
    public function isFavourited() 
    {
        return (bool) $this->favourites()
            ->where('user_id', auth()->user()->id)
            ->exists();
    }

    /**
     * Add isFavourited attribute to a model.
     * 
     * @return bool
     */
    public function getIsFavouritedAttribute() 
    {
        return (auth()->user()) ? $this->isFavourited() : false;
    }
}