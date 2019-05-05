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
    public function test_user_can_view_a_city() 
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

    //@test
   public function test_display_suggested_cities_on_main_page()
   {
       $room = RoomFactory::create();
       $roomExcluded = RoomFactory::create();

       $this->get(route('cities.show', $room->city->slug))
           ->assertSee($room->title)
           ->assertDontSee($roomExcluded->title);
   }
}
