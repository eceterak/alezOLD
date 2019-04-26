<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\StreetFactory;
use App\Street;
use App\City;

class StreetTest extends TestCase
{

    use RefreshDatabase;

    // @test
    public function test_street_requires_a_name()
    {
        $this->admin();

        $city = factory(City::class)->create();

        $street = factory(City::class)->raw([
            'name' => ''
        ]);

        $this->post(route('admin.streets.store', $city->path()), $street)->assertSessionHasErrors('name');
    }

    // @test
    public function test_street_requires_latitude_and_longtitude()
    {
        $this->admin();

        $city = factory(City::class)->create();

        $street = factory(City::class)->raw([
            'lat' => '',
            'lon' => ''
        ]);

        $this->post(route('admin.streets.store', $city->path()), $street)->assertSessionHasErrors(['lat', 'lon']);
    }

    // @test
    public function test_street_can_be_found_by_a_path()
    {
        $street = StreetFactory::create();

        $this->assertInstanceOf('App\Street', Street::getByPath($street->city->path(), $street->path()));
    }

    // @test
    public function test_street_belongs_to_a_city()
    {
        $street = StreetFactory::create();        

        $this->assertInstanceOf('App\City', $street->city);
    }

}
