<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * 
     * 
    */
    public function test_city_has_a_path() 
    {
        $city = factory('App\City')->create();
        
        $this->assertEquals("/{$city->name}", $city->path());
    }
}
