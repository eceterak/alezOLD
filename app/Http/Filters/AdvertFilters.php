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
        'livingroom'
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
                $this->builder->orderBy('created_at', 'asc');
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
     * Filter adverts by minimum stay duration.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function staymin($value = 1)
    {
        return $this->builder->where('minimum_stay', '>=', $value);
    }

    /**
     * Filter adverts by maximum stay duration.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function staymax($value = 36)
    {
        return $this->builder->where('maximum_stay', '<=', $value);
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
     * Filter adverts by gender.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function gender($value = null)
    {
        return $this->builder->where('gender', $value);
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
        return $this->builder->where('minimum_age', '>=', $value);
    }

    /**
     * Filter adverts by maximum age allowed.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function agemax($value = null)
    {
        return $this->builder->where('maximum_age', '<=', $value);
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
     * Filter adverts by maximum age allowed.
     * 
     * @param int $value
     * @return QueryBuilder
     */
    public function smoking($value = null)
    {
        if($value == 'nonsmokers') $this->builder->where('smoking', false);
        elseif($value == 'smokers') $this->builder->where('smoking', true);

        return $this->builder;
    }

    /**
     * Display only those adverts, containing a living room.
     * 
     * @return QueryBuilder
     */
    public function pets($value = null)
    {
        return $this->builder->where('pets', $value);
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
}