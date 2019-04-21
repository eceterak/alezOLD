<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter 
{

    protected $request;

    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach($this->filters() as $key => $value) {
            if(method_exists($this, $key)) {
                (trim($value)) ? $this->$key($value) : $this->$key();
            }
        }

        return $this->builder;
    }

    public function filters()
    {
        return $this->request->all();
    }

}