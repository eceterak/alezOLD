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
    public function test_admin_can_create_a_room()
    {
        $this->withoutExceptionHandling();

        $this->admin();

        $street = StreetFactory::create();

        $this->get(action('Admin\RoomsController@create'))->assertStatus(200);

        $this->post(route('admin.rooms.store', $attributes = factory(Room::class)->raw([
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ])))
        ->assertRedirect(route('admin.rooms'));

        $room = Room::where($attributes)->first();

        $this->get(route('admin.rooms'))->assertSee($room->shortTitle());
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
        ]))
        ->assertRedirect(route('admin.rooms'));

        $this->assertDatabaseHas('rooms', $attributes);
    }

    // @test
    public function test_a_room_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->admin();

        $room = RoomFactory::create();

        $this->delete(route('admin.rooms.destroy', $room->id))->assertRedirect(route('admin.rooms'));

        $this->assertDatabaseMissing('rooms', $room->only('id'));
    }
}
