<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'changes' => 'array'
    ];

    /**
     * Eager load instance of user.
     * 
     * @var array
     */
    protected $with = [
        'user'
    ];

    /**
     * Activity belongs to user.
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
     * Get activity feed for given user.
     * 
     * @return array
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
