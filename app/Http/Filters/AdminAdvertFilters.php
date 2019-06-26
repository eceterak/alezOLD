<?php

namespace App\Filters;

class AdminAdvertFilters extends AdvertFilters
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
        'verified',
        'revised',
        'archived'
    ];

    /**
     * Filter adverts by verification status.
     * 
     * @param string $value
     * @return QueryBuilder
     */
    public function verified($value = 'y')
    {
        if($value == 'n') $this->builder->where('verified', false);
        elseif($value == 'y') $this->builder->where('verified', true);

        return $this->builder;
    }

    /**
     * Filter adverts by revision status.
     * 
     * @param string $value
     * @return QueryBuilder
     */
    public function revised($value = 'y')
    {
        if($value == 'n') $this->builder->where('revision', '!=', null);
        elseif($value == 'y') $this->builder->where('revision', null);

        return $this->builder;
    }

    /**
     * Filter adverts by archivization status.
     * 
     * @param string $value
     * @return QueryBuilder
     */
    public function archived($value = 'y')
    {
        if($value == 'n') $this->builder->where('archived', false);
        elseif($value == 'y') $this->builder->where('archived', true);

        return $this->builder;
    }
}