<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;
use App\Room;
use Facades\Tests\Setup\CityFactory;
use App\Street;

class CityTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    // @test
    public function test_city_requires_a_name()
    {
        $this->admin();

        $this->post(route('admin.cities.store'), factory(City::class)->raw([
            'name' => ''
        ]))->assertSessionHasErrors('name');
    }

    // @test
    public function test_city_requires_latitude_and_longtitute()
    {
        $this->admin();

        $this->post(route('admin.cities.store'), factory(City::class)->raw([
            'lat' => '',
            'lon' => '',
        ]))->assertSessionHasErrors(['lat', 'lon']);
    }

    // @test
    public function test_city_requires_a_county_and_a_state()
    {
        $this->admin();

        $this->post(route('admin.cities.store'), factory(City::class)->raw([
            'county' => '',
            'state' => ''
        ]))->assertSessionHasErrors(['county', 'state']);
    }

    // @test
    public function test_city_has_a_path() 
    {
        $city = factory(City::class)->create();
        
        $this->assertEquals(preparePath($city->name), $city->path());
    }

    // @test
    public function test_city_has_streets()
    {
        $city = CityFactory::create();

        $street = factory(Street::class)->create([
            'city_id' => $city->id
        ]);

        $this->assertInstanceOf('App\Street', $city->streets->first());
    }

/*     // @test
    public function test_city_can_have_rooms() 
    {
        $this->withExceptionHandling();

        $city = CityFactory::create();

        $room = factory(Room::class)->raw([
            'title' => 'short title',
            'user_id' => $this->user()
        ]);

        $city->rooms()->create($room);

        $this->get(route('admin.cities.edit', $city->path()))->assertSee($room['title']);
    } */
}
