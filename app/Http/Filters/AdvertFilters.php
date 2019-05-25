<?php

namespace App\Filters;

class AdvertFilters extends QueryFilter
{

    protected $filters = [
        'livingroom', 'rentmin', 'rentmax', 'sort', 'pets'
    ];

    /**
     * Sort.
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
     * Order by rent.
     * 
     * @param string $order
     * @return QueryBuilder
     */
    public function ownedBy($id = null) 
    {
        return $id === null ? '' : $this->builder->where('user_id', $id);
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
     * Display only those adverts, containing a living room.
     * 
     * @return QueryBuilder
     */
    public function pets($value = 1)
    {
        return $this->builder->where('pets', $value);
    }

    /**
     * Display only those adverts, containing a living room.
     * 
     * @return QueryBuilder
     */
    public function rentmin($value = 1)
    {
        return $this->builder->where('rent', '>=', $value);
    }

    /**
     * Display only those adverts, containing a living room.
     * 
     * @return QueryBuilder
     */
    public function rentmax($value = 1)
    {
        return $this->builder->where('rent', '<=', $value);
    }    
}