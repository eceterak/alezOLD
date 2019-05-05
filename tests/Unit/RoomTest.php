<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function test_room_can_be_verified()
    {
        $this->admin();

        $room = RoomFactory::create();

        $this->patch(route('admin.rooms.update', $room->slug), [
            'verified' => true
        ]);

        $room->refresh();

        $this->assertTrue($room->verified);
        $this->assertTrue($room->active);
    }

    // @test
    public function test_it_can_start_a_conversation()
    {
        $this->user();

        $room = RoomFactory::create();

        $room->inquiry('hi');

        $this->assertCount(1, $room->conversations);
    }
}
