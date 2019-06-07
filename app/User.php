<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'active', 'email', 'password', 'bio', 'email_notifications', 'avatar_path', 'notifications_count', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id', 'name', 'role', 'avatar_path', 'email_verified_at', 'notifications_count'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'email_verified_at' => 'datetime',
        'email_notifications' => 'boolean'
    ];

    /**
     * User has many adverts.
     *
     * @return Collection
     */
    public function adverts() 
    {
        return $this->hasMany(Advert::class)->latest();
    }

    /**
     * Get all conversations user participates in.
     * 
     * @return App\Conversation
     */
    public function conversations() 
    {
        return $this->belongsToMany(Conversation::class);
    }

    /**
     * User has many activities.
     * 
     * @return App\Activity
     */
    public function activities() 
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get all messages.
     * 
     * @return App\Message
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get all favourites.
     * 
     * @return App\Favourite
     */
    public function favourites() 
    {
        return $this->hasMany(Favourite::class);
    }

    /**
     * Get all favourites.
     * 
     * @return App\CitySubscription
     */
    public function subscriptions() 
    {
        return $this->hasMany(CitySubscription::class);
    }

    /**
     * Get latest Advert that belongs to user.
     * 
     * @return App\Advert
     */
    public function lastAdvert()
    {
        return $this->hasOne(Advert::class)->latest();
    }

    /**
     * Check if user has admin privileges.
     * 
     * @return bool
     */
    public function isAdmin() 
    {
        return $this->role === 1;
    }

    /**
     * Returns name or message if account is deleted.
     * 
     * @return string
     */
    public function getNameAttribute($name) 
    {
        return (!$this->active) ? 'Konto usunięte' : $name;
    }

    /**
     * Returns full path to users account.
     * In case if user deleted an account, return apprioprate message.
     * 
     * @return string
     */
    public function getPathAttribute() 
    {
        return (!$this->active) ? '<span class="text-muted">konto usunięte</span>' : '<a href="'.route('profiles.show', $this->id).'">'.$this->name.'</a>';
    }

    /**
     * Return a path to avatar or default image if user has not uploaded one.
     * 
     * @return string
     */
    public function getAvatarPathAttribute($avatar_path) 
    {
        return (!is_null($avatar_path)) ? '/storage/'.$avatar_path : $this->avatarNotFoundPath();
    }

    /**
     * As there is a custom getter on avatar_path, 
     * to determine if user has uploaded a avatar compare her avatar_path with default, not found path.
     * 
     * @return bool
     */
    public function hasUploadedAvatar() 
    {
        return $this->avatarNotFoundPath() != $this->avatar_path;
    }

    /**
     * User read the conversation.
     * 
     * @param App\Conversation $conversation
     * @return void
     */
    public function read($conversation) 
    {
        cache()->forever($this->visitedConversationCacheKey($conversation), Carbon::now());
    }

    /**
     * Return a cache key for visited conversation.
     * 
     * @param App\Conversation $conversation
     * @return string
     */
    public function visitedConversationCacheKey($conversation) 
    {
        return sprintf("users.%d.visits.%d", $this->id, $conversation->id);
    }

    /**
     * Return a path to notFound avatar/dummy user image.
     * 
     * @return string
     */
    public function avatarNotFoundPath() 
    {
        return '/storage/avatars/notfound.jpg';
    }

    /**
     * Check if user has uploaded a avatar, remove it
     * and update avatar_path to null.
     * 
     * @return void
     */
    public function deleteAvatar() 
    {
        if($this->hasUploadedAvatar())
        {
            $path = str_replace('/storage/', '', $this->avatar_path);

            Storage::disk('public')->delete($path);
    
            $this->update([
                'avatar_path' => null
            ]);
        }
    }

    /**
     * Check if user has unready notifications of a given type.
     * 
     * @param string $type
     * @return Collection
     */
    public function hasUnreadNotificationsOfType($type)
    {
        $count = $this->unreadNotifications()->where('type', "App\\Notifications\\{$type}")->count();

        return ($count > 99) ? '99+' : $count;
    }

    /**
     * If notifications count is greater than 99, return 99+ so it won't breake design.
     * 
     * @return null/string/int
     */
    public function getNotificationsCountAttribute($notifications_count = null) 
    {
        $count = $notifications_count ?? $this->unreadNotifications()->count();

        return $this->attributes['notifications_count'] = ($count > 99) ? '99+' : $count;
    }

    /**
     * When visiting a subject, check if user has any notifications
     * about it and mark them as read.
     * 
     * @param mixed $subject
     * @return
     */
    public function sawNotificationsFor($subject) 
    {
        $notification = $this->unreadNotifications()->where('subject_type', get_class($subject))->where('subject_id', $subject->id)->get();

        if($notification) $notification->markAsRead();
    }

    /**
     * Check if user accepts notifications for a given channel.
     * 
     * @return boolean
     */
    public function acceptsEmailNotifications()
    {
        return $this->email_notifications;
    }

    /**
     * Desactivate the account, archive all of users adverts.
     * Favourites, subscriptions and notifications are deleted trough
     * mysql foreign key cascade delete.
     * 
     * @return
     */
    public function deleteAccount() 
    {
        auth()->logout();
        
        $this->update([
            'name' => 'deleted',
            'active' => false,
            'email' => 'deleted',
            'password' => 'deleted',
            'bio' => 'deleted',
            'deleted_at' => now()
        ]);

        $this->adverts()->update([
            'archived' => true
        ]);

        $this->deleteAvatar();

        $this->favourites()->delete();
        $this->subscriptions()->delete();
        $this->notifications()->delete();
        $this->activities()->delete();
    }
}
