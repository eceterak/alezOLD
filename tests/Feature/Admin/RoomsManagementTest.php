<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\RoomFactory;
use Facades\Tests\Setup\StreetFactory;
use App\Room;

class RoomsManagementTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_guests_cannot_manage_rooms() 
    {
        $room = RoomFactory::create();

        $this->get(route('admin.rooms'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.rooms.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.rooms.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.rooms.edit', [$room->slug]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.rooms.update', [$room->slug]), [])->assertRedirect(route('admin.login'));
    }

    // @test
    public function test_admin_can_create_a_room()
    {
        $street = StreetFactory::create();

        $this->admin();

        $attributes = factory(Room::class)->raw([
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ]);

        $this->post(route('admin.rooms.store', $attributes))->assertRedirect(route('admin.rooms'));

        $room = Room::where($attributes)->first();

        $this->get(route('admin.rooms.edit', $room->slug))->assertSee($attributes['title']);

        $this->assertDatabaseHas('rooms', $attributes);
    }

    // @test
    public function test_admin_can_update_any_room() 
    {
        $this->admin();

        $room = RoomFactory::create();

        $this->get(route('admin.rooms.edit', $room->slug))->assertSee($room->title);

        $this->patch(route('admin.rooms.update', [$room->slug]), $attributes = factory(Room::class)->raw([
            'city_id' => $room->city->id,
            'street_id' => $room->street->id
        ]))->assertRedirect(route('admin.rooms'));

        $this->assertDatabaseHas('rooms', $attributes);
    }

    // @test
    public function test_rooms_are_listed() 
    {
        $this->admin();

        $room = RoomFactory::create();

        $this->get(route('admin.rooms'))->assertSee($room->shortTitle());
    }

    // @test
    public function test_room_can_be_verified()
    {
        $this->withoutExceptionHandling();

        $this->admin();

        $room = RoomFactory::create();

        $this->patch(route('admin.rooms.update', $room->slug), [
            'verified' => true
        ]);

        $room->refresh();

        $this->assertTrue($room->verified);
        $this->assertTrue($room->active);
    }
}
