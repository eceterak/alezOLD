<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $casts = [
        'changes' => 'array'
    ];

    protected $with = [
        'user'
    ];

    /**
     * Activity is associated with user.
     * 
     * @return App\User
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get object associated with activity.
     * 
     * @return mixed
     */
    public function subject() 
    {
        return $this->morphTo();
    }

    /**
     * Get object associated with activity.
     * 
     * @return mixed
     */
    public static function feed($user) 
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take(50)
            ->get()
            ->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });
    }
    
}
