<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter 
{

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var Builder $builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach($this->filters() as $filter => $value) {
            if(!method_exists($this, $filter)) return;

            (trim($value)) ? $this->$filter($value) : $this->$filter();
        }

        return $this->builder;
    }

    public function filters()
    {
        return $this->request->only($this->filters);
    }
}