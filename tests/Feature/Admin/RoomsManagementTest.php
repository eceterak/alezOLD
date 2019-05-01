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
        $this->get(route('admin.rooms.edit', [$room->path()]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.rooms.update', [$room->path()]), [])->assertRedirect(route('admin.login'));
    }

    // @test
    public function test_admin_can_create_a_room()
    {
        $this->withoutExceptionHandling();

        $city = CityFactory::create();

        $this->admin();

        $attributes = factory(Room::class)->raw([
            'user_id' => auth()->user()->id, 
            'city_id' => $city->id
        ]);

        $this->post(route('admin.rooms.store', $attributes))->assertRedirect(route('admin.rooms'));

        $room = Room::where($attributes)->first();

        $this->get(route('admin.rooms.edit', $room->path()))->assertSee($attributes['title']);
    }

    // @test
    public function test_admin_can_update_any_room() 
    {
        $this->admin();

        $room = RoomFactory::create();
        
        $this->get(route('admin.rooms.edit', [$room->path()]))->assertSee($room->title);

        $room->title = 'new title';
        $room->city->id = 11;

        $this->patch(route('admin.rooms.update', [$room->path()]), $room->toArray())->assertRedirect(route('admin.rooms'));

        $this->assertDatabaseHas('rooms', [
            'title' => 'new title'
        ]);
    }

}
