<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\StreetFactory;
use Facades\Tests\Setup\RoomFactory;
use App\City;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_it_belongs_to_an_owner()
    {
        $room = RoomFactory::ownedBy($this->user())->create();

        $this->assertInstanceOf('App\User', $room->user);

        $this->assertEquals(auth()->user()->id, $room->user->id);
    }

    // @test
    public function test_it_is_associated_with_a_city() 
    {
        $room = RoomFactory::create();

        $this->assertInstanceOf(City::class, $room->city);
    }

    // @test
    public function test_it_has_a_slug()
    {
        $room = RoomFactory::create();

        $this->assertEquals(str_slug($room->title.'-uid-'.$room->id), $room->slug);
    }

    // @test
    public function test_room_requires_attributes() 
    {
        $this->user();

        $this->post(route('rooms.store'), [])->assertSessionHasErrors([
            'city_id', 'title', 'description', 'rent'
        ]);
    }

    // @test
    public function test_user_can_create_a_room()
    {   
        $this->withoutExceptionHandling();

        $this->user();

        $this->get(route('rooms.create'))->assertStatus(200);

        $street = StreetFactory::create();

        $attributes = [
            'city_id' => $street->city->id,
            'street_id' => $street->id,
            'title' => 'Hi ho',
            'description' => 'Hio hio hio',
            'rent' => 123,
            'deposit' => 123,
            'bills' => 100
        ];
        
        $this->post(route('rooms.store'), $attributes)->assertRedirect(route('home'));

        /* $room = Room::where($attributes)->first();
        
        $this->get(route('rooms'))->assertSee($attributes['title']);

        $this->get(route('rooms.show', [$street->city->slug, $room->slug]))->assertSee($attributes['title']); */
    }
}
