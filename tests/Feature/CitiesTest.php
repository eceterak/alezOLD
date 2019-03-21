<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CitiesTest extends TestCase
{
    /**
     * Anyone can view a city.
     * 
     * @return void
     */
    public function test_guest_can_view_a_city() 
    {
        $this->withoutExceptionHandling();
        
        $city = factory('App\City')->create();

        $this->get("/{$city->path()}")->assertSee($city->name);
    }
}
