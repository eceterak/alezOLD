<?php

function create($class, $attributes = [], $amount = null)
{
    return factory($class, $amount)->create($attributes);
}

function raw($class, $attributes = [], $amount = null)
{
    return factory($class, $amount)->raw($attributes);
}