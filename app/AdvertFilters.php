<?php

namespace App;

class AdvertFilters extends QueryFilter
{

    public function rent($order = 'desc') 
    {
        return $this->builder->orderBy('rent', $order);
    }

    public function livingRoom()
    {
        return $this->builder->where('living_room', 1);
    }

}