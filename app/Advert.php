<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;
use App\Traits\RecordsActivity;
use App\Traits\Favouritable;
use Carbon\Carbon;

class Advert extends Model
{
    use RecordsActivity, Favouritable;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Eager load city, user and favourites.
     * 
     * @var array
     */
    protected $with = [
        'city',
        'user'
    ];
    
    /**
     * Register custom attributes.
     * 
     * @var array
     */
    protected $appends = [
        'isFavourited', 'FeaturedPhotoPath', 'PhoneTranslated'
    ];

    /**
     * Casts from database to model.
     * 
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
        'archived' => 'boolean',
        'revision' => 'array',
        'available_from' => 'datetime'
    ];

    /**
     * Hide those attributes from view.
     * 
     * @var array
     */
    protected $hidden = [
        'phone'
    ];

    /**
     * Replace default key for route model binding.
     * 
     * @return string
     */
    public function getRouteKeyName() 
    {
        return 'slug';
    }

    /**
     * Advert belongs to user.
     * 
     * @return App\User
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Advert belongs to city.
     * 
     * @return App\City
     */

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Advert belongs to street.
     * 
     * @return App\City
     */

    public function street()
    {
        return $this->belongsTo(Street::class);
    }

    /**
     * Advert can have many conversations.
     * 
     * @return App\Conversation
     */
    public function conversations() 
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * Get photos.
     * 
     * @return App\Photo
     */
    public function photos() 
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Set a unique slug based on the title and id.
     * 
     * @param string $title
     */
    public function setSlugAttribute($title) 
    {
        $slug = str_slug($title);

        if(static::where('slug', $slug)->exists())
        {
            $slug = $slug.'-'.substr(md5(now()), 0, 3).str_random(2);
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Display additional info if advert is deleted (archived).
     * 
     * @return string
     */
    public function getTitleAttribute($title) 
    {
        return ($this->archived) ? $title.' (zakończone)' : $title;
    }

    /**
     * Get the path to the featured photo if any found.
     * 
     * @return string
     */
    public function getFeaturedPhotoPathAttribute() 
    {
        $featured = $this->photos()->where('order', 0)->first();

        return ($featured) ? 'https://alez.s3.eu-central-1.amazonaws.com/'.$featured->url : '/storage/photos/notfound.jpg';
    }

    /**
     * Display only three digits of phone number and hide the rest with X.
     * 
     * @return string
     */
    public function getPhoneTranslatedAttribute() 
    {
        $sub = substr($this->phone, 3);
        $sub = preg_replace('/[a-zA-Z0-9\s]/', 'X', $sub);

        $phone = substr($this->phone, 0, 3).$sub;

        return wordwrap($phone, 3, ' ', true);
    }

    /**
     * As bills can be null, cast it to integer.
     * 
     * @return int
     */
    public function getBillsTranslatedAttribute() 
    {
        return intval($this->bills);
    }
   
    /**
     * As deposit can be null, cast it to integer.
     * 
     * @return int
     */
    public function getDepositTranslatedAttribute() 
    {
        return intval($this->deposit);
    }
     
    /**
     * Translate room size to polish.
     * 
     * @return string
     */
    public function getRoomSizeTranslatedAttribute() 
    {
        $room_size = null;

        switch($this->room_size)
        {
            case 'single':
            default:
                $room_size = 'jednoosobowy';
            break;
            case 'double':
                $room_size = 'dwuosobowy';
            break;
            case 'triple':
                $room_size = 'trzyosobowy i więcej';
            break;
        }

        return $room_size;
    }
 
    /**
     * If room is available straight away return correct message.
     * Otherwise, return formated date.
     * Must parse date to carbon because otherwise format method won't work.
     * 
     * @return string
     */
    public function getAvailableFromTranslatedAttribute() 
    {
        $this->available_from = Carbon::parse($this->available_from);

        if($this->available_from <= now()) return 'od zaraz';

        return $this->available_from->format('Y-m-d');
    }

    /**
     * Return minimum stay or no preferences if attribute is set to null.
     * 
     * @return string
     */
    public function getMinimumStayTranslatedAttribute() 
    {
        if(is_null($this->minimum_stay)) return 'brak preferencji';

        return ($this->minimum_stay == 1) ? $this->minimum_stay.' miesiąc' : $this->minimum_stay.' miesięcy';
    }

    /**
     * Return maximum stay or no preferences if attribute is set to null.
     * 
     * @return string
     */
    public function getMaximumStayTranslatedAttribute() 
    {
        if(is_null($this->maximum_stay)) return 'brak preferencji';

        return ($this->maximum_stay == 1) ? $this->maximum_stay.' miesiąc' : $this->maximum_stay.' miesięcy';
    }

    /**
     * Return furnished attribute in polish instead of boolean 
     * 
     * @return string
     */
    public function getFurnishedTranslatedAttribute() 
    {
        return $this->furnished ? 'tak' : 'nie';
    }
  
    /**
     * Return broadband attribute in polish instead of boolean 
     * 
     * @return string
     */
    public function getBroadbandTranslatedAttribute() 
    {
        return $this->broadband ? 'tak' : 'nie';
    }
 
    /**
     * Return parking attribute in polish instead of boolean 
     * 
     * @return string
     */
    public function getParkingTranslatedAttribute() 
    {
        return $this->parking ? 'tak' : 'nie';
    }

    /**
     * Return gender attribute in polish.
     * 
     * @return string
     */
    public function getGenderTranslatedAttribute() 
    {
        if(is_null($this->gender)) return 'brak preferencji';

        return ($this->gender == 'f') ? 'kobieta' : 'męszczyzna';
    }

    /**
     * Return occupation attribute in polish.
     * 
     * @return string
     */
    public function getOccupationTranslatedAttribute() 
    {
        if(is_null($this->occupation)) return 'brak preferencji';

        return ($this->occupation == 'student') ? 'student' : 'pracujący';
    }

    /**
     * Return minimum age or no preferences if attribute is set to null.
     * 
     * @return string/int
     */
    public function getMinimumAgeTranslatedAttribute() 
    {
        return is_null($this->minimum_age) ? 'brak preferencji' : $this->minimum_age;
    }

    /**
     * Return maximum age or no preferences if attribute is set to null.
     * 
     * @return string/int
     */
    public function getMaximumAgeTranslatedAttribute() 
    {
        return is_null($this->maximum_age) ? 'brak preferencji' : $this->maximum_age;
    }
    
    /**
     * Return smoking attribute in polish instead of boolean 
     * 
     * @return string
     */
    public function getSmokingTranslatedAttribute() 
    {
        return $this->smoking ? 'tak' : 'nie';
    }
    
    /**
     * Return couples attribute in polish instead of boolean 
     * 
     * @return string
     */
    public function getCouplesTranslatedAttribute() 
    {
        return $this->couples ? 'tak' : 'nie';
    }
    
    /**
     * Return pets attribute in polish instead of boolean 
     * 
     * @return string
     */
    public function getPetsTranslatedAttribute() 
    {
        return $this->pets ? 'tak' : 'nie';
    }

    /**
     * Check if phone number is assigned and user allows to display it.
     * 
     * @return bool
     */
    public function hasVisiblePhoneNumber() 
    {
        return $this->phone && !$this->user->hide_phone;
    }

    /**
     * Scope to get access to QueryBuilder.
     * 
     * @param $query
     * @param QueryFilter $filters
     * @return QueryFilters
     */
    public function scopeFilter($query, QueryFilter $filters) 
    {
        return $filters->apply($query);
    }

    /**
     * Verify an advert.
     * 
     * @return this
     */
    public function verify() 
    {
        $this->update([
            'verified' => true
        ]);

        //$this->recordActivity('verified_advert');

        return $this;
    }

    /**
     * Archive an advert.
     * 
     * @return this
     */
    public function archive() 
    {
        $this->update([
            'archived' => true
        ]);

        //$this->recordActivity('deleted_advert');

        return $this;
    }

    /**
     * Send an inquiry about the advert.
     * 
     * @param string $body
     * @param App\User $user
     * @return App\Conversation
     */
    public function inquiry($body, $user = null) 
    {
        $user = ($user) ?? auth()->user();

        $conversation = $this->conversations()->create();

        // Update the conversation_user pivot table.
        $conversation->users()->sync([$user->id, $this->user->id]);

        // Send a message.
        $conversation->reply($body, $this, $user);

        return $conversation;
    }

    /**
     * Check if advert was published within the last minute.
     * 
     * @return boolean
     */
    public function wasJustPublished() 
    {
        // gt stands for Greater Than, subMinute, substracts a minute from current time.
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    /**
     * Register has_pending_revision attribute.
     * 
     * @return bool
     */
    public function getHasPendingRevisionAttribute() 
    {
        return ! empty($this->revision);
    }

    /**
     * Check if there are any unsaved (unverified) changes to the model and update the model.
     * 
     * @return $this
     */
    public function loadPendingRevision() 
    {
        if($this->has_pending_revision)
        {
            foreach($this->revision as $key => $value)
            {
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    /**
     * Accept revision.
     * 
     * @return void
     */
    public function acceptRevision() 
    {
        $this->loadPendingRevision()->save();
    }
}