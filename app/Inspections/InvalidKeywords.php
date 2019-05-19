<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    protected $invalidKeyWords = [
        'spam'
    ];

    public function detect($body) 
    {
        foreach($this->invalidKeyWords as $keyword)
        {
            if(stripos($body, $keyword) !== false)
            {
                throw new Exception('Spammm');
            }
        }
    }
}
