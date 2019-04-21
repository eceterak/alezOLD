<?php

namespace App;

class RoomFilters extends QueryFilter
{

    public function rent($order = 'desc') 
    {
        return $this->builder->orderBy('rent', $order);
    }

    public function livingroom()
    {
        return $this->builder->where('living_room', 1);
    }

}