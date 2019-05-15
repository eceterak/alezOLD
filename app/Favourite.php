<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;

class Favourite extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }
}
