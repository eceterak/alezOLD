<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\CityFactory;
use Facades\Tests\Setup\StreetFactory;
use App\City;
use App\Street;
use App\Room;

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
    public function test_a_slug_can_be_created()
    {
        $city = CityFactory::create();

        $city->createSlug();

        $this->assertEquals(str_slug($city->name), $city->slug);
    }

    // @test
    public function test_city_has_a_slug() 
    {
        $city = factory(City::class)->create();
        
        $this->assertIsString($city->slug);
    }

    // @test
    public function test_city_has_streets()
    {
        $city = factory(City::class)->create();

        factory(Street::class)->create([
            'city_id' => $city->id
        ]);

        $this->assertInstanceOf('App\Street', $city->streets->first());
    }

    // @test
    public function test_city_can_have_rooms() 
    {
        $city = factory(City::class)->create();

        $room = factory(Room::class)->raw([
            'user_id' => $this->user(),
            'city_id' => $city->id
        ]);

        $room = $city->rooms()->create($room);

        $this->assertDatabaseHas('rooms', $room->only('id'));

        $this->get(route('cities.show', $city->slug))->assertSee($room->title);
    }
}
