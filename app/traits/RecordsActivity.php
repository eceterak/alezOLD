<?php

namespace App\Traits;

use App\Activity;

trait RecordsActivity
{
    /**
     * Attributes from before change.
     * 
     * @var array
     */
    protected $oldAttributes = [];

    /**
     * Events to record activity of.
     * 
     * @var array
     */
    protected static $recordableEvents = [
        'created', 'updated'
    ];

    /**
     * Boot the trait.
     * 
     * @return void
     */
    public static function bootRecordsActivity() 
    {
        foreach(self::$recordableEvents as $event)
        {
            static::$event(function($model) use ($event)
            {
                $model->recordActivity($model->activityDescription($event));
            });

            if($event == 'updated')
            {
                //Save the status from before the update.
                static::updating(function($model)
                {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }

        static::deleting(function($model) 
        {
            $model->activities()->delete();
        });
    }

    /**
     * Create the name of the activity.
     * 
     * @return string
     */
    protected function activityDescription($description) 
    {
        return "{$description}_".strtolower(class_basename($this)); // created_user
    }

    /**
     * Return all activities for model.
     * 
     * @return App\Activity
     */
    public function activities() 
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * Record an activity.
     * 
     * @param string $description
     * @return void
     */
    public function recordActivity($description) 
    {
        $this->activities()->create([
            'user_id' => $this->activityOwner()->id,
            'description' => $description,
            'changes' => $this->activityChanges($description)
        ]);
    }

    /**
     * Who made a changes.
     * 
     * @return App\User
     */
    protected function activityOwner() 
    {
        if(auth()->check()) return auth()->user();
        
        return $this->user;
    }

    /**
     * Fetch the changes to the model.
     * 
     * @return array
     */
    protected function activityChanges() 
    {
        if($this->wasChanged())
        {
            return [
                'before' => array_except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => array_except($this->getChanges(), 'updated_at')
            ];
        }
    }
}