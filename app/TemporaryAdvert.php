<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemporaryAdvert extends Model
{ 
    /**
     * Generate a token before adding to database.
     * 
     * @return void
     */
    public function generateToken() 
    {
        $this->token = str_random(40);
    }
}
