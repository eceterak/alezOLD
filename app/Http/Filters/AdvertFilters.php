<?php

namespace App\Filters;

class AdvertFilters extends QueryFilter
{
    protected $filters = [
        'sort', 
        'rentmin', 'rentmax', 
        'staymin', 'staymax',
        'pets', 
        'gender',
        'roomsize',
        'occupation',
        'agemin', 'agemax',
        'availability',
        'smoking',
        'pets',
        'parking',
        'livingroom',
        'broadband',
        'furnished',
        'garage',
        'garden'
    ];

    /**
     * Sort by date or rent asc/desc.
     * 
     * @param string $order
     * @return QueryBuilder
     */
    public function sort($value = 'rent_asc') 
    {
        $this->builder->getQuery()->orders = []; // Reset the orders (only one can be applied at the same time).

        switch($value)
        {
            case 'date':
                $this->builder->orderBy('created_at', 'desc');
            break;

            case 'rent_desc': 
                $this->builder->orderBy('rent', 'desc');
            break;

            case 'rent_asc': 
            default:
                $this->builder->orderBy('rent', 'asc');
            break;
        }

        return $this->builder;
    }

    /**
     * Filter adverts by minimum rent.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function rentmin($value = 1)
    {
        return $this->builder->where('rent', '>=', $value);
    }

    /**
     * Filter adverts by maximum rent.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function rentmax($value = 1)
    {
        return $this->builder->where('rent', '<=', $value);
    }    

    /**
     * Filter adverts by room size.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function roomsize($value = null)
    {
        return $this->builder->where('room_size', $value);
    }

    /**
     * Filter adverts by maximum age allowed.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function availability($value = null)
    {
        $date = now();

        switch($value) 
        {
            case 'now':
                $this->builder->whereDate('available_from', '<=', $date);
            break;

            case 30:
                $date->addDays(30);

                $this->builder->where('available_from', '<=', $date);
            break;

            case 90:
                $date->addDays(90);

                $this->builder->where('available_from', '<=', $date);
            break;
        }

        return $this->builder;
    }

    /**
     * Filter adverts by gender.
     * Can also filter by couples.
     * 
     * @param string $value
     * @return QueryBuilder
     */
    public function gender($value = null)
    {
        if($value == 'couples') return $this->builder->where('couples', true);
        return $this->builder->where('gender', $value);
    }

    /**
     * Filter adverts by minimum stay duration.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function staymin($value = 1)
    {
        return $this->builder->where(function($query) use ($value) {
            $query->where('minimum_stay', '<=', $value)->orWhereNull('minimum_stay');
        });
    }

    /**
     * Filter adverts by maximum stay duration.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function staymax($value = 36)
    {
        return $this->builder->where(function($query) use ($value) {
            $query->where('maximum_stay', '<=', $value)->orWhereNull('maximum_stay');
        });
    }

    /**
     * Filter adverts by occupation.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function occupation($value = null)
    {
        return $this->builder->where('occupation', $value);
    }

    /**
     * Filter adverts by minimum age required.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function agemin($value = null)
    {
        return $this->builder->where(function($query) use ($value) {
            $query->where('minimum_age', '>=', $value)->orWhereNull('minimum_age');
        });
    }

    /**
     * Filter adverts by maximum age allowed.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function agemax($value = null)
    {
        return $this->builder->where(function($query) use ($value) {
            $query->where('maximum_age', '<=', $value)->orWhereNull('maximum_age');
        });
    }

    /**
     * Display only those adverts with furniture.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function furnished($value = null)
    {
        return $this->builder->where('furnished', $value);
    }

    /**
     * Display only those adverts, containing a living room.
     * 
     * @return QueryBuilder
     */
    public function broadband($value = 1)
    {
        return $this->builder->where('broadband', $value);
    }

    /**
     * Display only those adverts, containing a living room.
     * 
     * @return QueryBuilder
     */
    public function parking($value = null)
    {
        return $this->builder->where('parking', $value);
    }

    /**
     * Display only those adverts, containing a living room.
     * 
     * @return QueryBuilder
     */
    public function livingroom($value = 1)
    {
        return $this->builder->where('living_room', $value);
    }

    /**
     * Display only those adverts, containing a garage.
     * 
     * @return QueryBuilder
     */
    public function garage($value = 1)
    {
        return $this->builder->where('garage', $value);
    }

    /**
     * Display only those adverts, containing a garden.
     * 
     * @return QueryBuilder
     */
    public function garden($value = 1)
    {
        return $this->builder->where('garden', $value);
    }

    /**
     * If smoking value is sent with request,
     * it means that user is searching for a room
     * for a smokers - set nonsmoking to false.
     * Otherwise just return instance of builder.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function smoking($value = null)
    {
        return ($value) ? $this->builder->where('nonsmoking', false) : $this->builder;
    }

    /**
     * Display those adverts which accpets pets.
     * 
     * @return QueryBuilder
     */
    public function pets($value = null)
    {
        return $this->builder->where('pets', $value);
    }
}