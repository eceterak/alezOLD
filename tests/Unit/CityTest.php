<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;
use App\Advert;

class CityTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * City has a path.
     * 
     * @return test
     */
    public function test_city_has_a_path() 
    {
        $city = factory('App\City')->create();
        
        $this->assertEquals("/{$city->name}", $city->path());
    }

    /**
     * City requires a name.
     * 
     * @return test
     */
    public function test_city_requires_a_name()
    {
        $this->authenticated(null, true);

        $city = factory(City::class)->raw(['name' => '']);

        $this->post('/admin/miasta', $city)->assertSessionHasErrors('name');
    }
}
