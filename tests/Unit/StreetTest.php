<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\StreetFactory;
use App\Street;

class StreetTest extends TestCase
{

    use RefreshDatabase;

    // @test
    public function test_street_requires_a_name()
    {
        $this->admin();

        $street = StreetFactory::raw();

        $street['name'] = '';

        $this->post(route('admin.streets.store'), $street)->assertSessionHasErrors('name');
    }

    // @test
    public function test_street_requires_a_city()
    {
        $this->admin();

        $street = factory(Street::class)->raw();

        $this->post(route('admin.streets.store'), $street)->assertSessionHasErrors('city_id');
    }

    // @test
    public function test_street_requires_a_coordinates()
    {
        $this->admin();

        $street = StreetFactory::raw();

        $street['lat'] = '';
        $street['lon'] = '';

        $this->post(route('admin.streets.store'), $street)->assertSessionHasErrors(['lat', 'lon']);
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
