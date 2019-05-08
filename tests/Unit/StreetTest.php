<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\StreetFactory;
use App\City;

class StreetTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function street_requires_a_name()
    {
        $this->signInAdmin();

        $city = factory(City::class)->create();

        $street = factory(City::class)->raw([
            'name' => ''
        ]);

        $this->post(route('admin.streets.store', $city->slug), $street)->assertSessionHasErrors('name');
    }

    /** @test */
    public function street_requires_latitude_and_longtitude()
    {
        $this->signInAdmin();

        $city = factory(City::class)->create();

        $street = factory(City::class)->raw([
            'lat' => '',
            'lon' => ''
        ]);

        $this->post(route('admin.streets.store', $city->slug), $street)->assertSessionHasErrors(['lat', 'lon']);
    }

    /** @test */
    public function street_belongs_to_a_city()
    {
        $street = StreetFactory::create();        

        $this->assertInstanceOf('App\City', $street->city);
    }

}
