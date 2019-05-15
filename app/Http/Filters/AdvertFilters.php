<?php

namespace App\Filters;

class AdvertFilters extends QueryFilter
{

    protected $filters = [
        'livingroom', 'rent'
    ];

    /**
     * Order by rent.
     * 
     * @param string $order
     * @return QueryBuilder
     */
    public function rent($order = 'desc') 
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('rent', $order);
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
    public function livingRoom($value = 1)
    {
        return $this->builder->where('living_room', $value);
    }
    
}