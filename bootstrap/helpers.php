<?php

/**
 * Generate a seo-friendly url.
 * 
 * @param string $string
 * @return string
 */
function preparePath($string)
{
    $string = strtolower(str_replace(' ', '-', $string));
    
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

/**
 * Parse path into database friendly string.
 * 
 * @param string $string
 * @return string
 */
function parsePath($string)
{
    return str_replace('-', ' ', $string);
}