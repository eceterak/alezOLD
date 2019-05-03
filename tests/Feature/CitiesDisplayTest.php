<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\CityFactory;
use Facades\Tests\Setup\RoomFactory;

class CitiesDisplayTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_guests_cannot_manage_cities() 
    {
        $city = CityFactory::create();

        $this->get(route('admin.cities'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.cities.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.edit', [$city->slug]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.cities.update', [$city->slug]), [])->assertRedirect(route('admin.login'));
    }

    // @test
    public function test_guest_can_view_a_city() 
    {        
        $city = CityFactory::create();

        $this->get(route('cities'))->assertSee($city->name);

        $this->get(route('cities.show', $city->slug))->assertSee($city->name);
    }

    //@test
    public function test_city_can_have_rooms()
    {
        $this->withoutExceptionHandling();
        
        $room = RoomFactory::create();

        $this->get(route('cities.show', $room->city->slug))->assertSee($room->title);
    }

    //@test
   public function test_dont_display_rooms_of_other_city()
    {
        $room = RoomFactory::create();
        $roomExcluded = RoomFactory::create();

        $this->get(route('cities.show', $room->city->slug))
            ->assertSee($room->title)
            ->assertDontSee($roomExcluded->title);
    }
}
