<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Room;
use Tests\Setup\RoomFactory;
use Tests\Setup\CityFactory;

class RoomsManagementTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * Admin can create a room.
     * 
     * @return void
     */
    public function test_admin_can_create_a_room()
    {
        $this->withoutExceptionHandling();

        $this->authenticated(null, true);

        $this->get(route('admin.rooms.create'))->assertStatus(200);

        $room = factory(Room::class)->raw(['user_id' => auth()->user()->id]);

        $this->post(route('admin.rooms.store', $room))->assertRedirect(route('admin.rooms'));

        $this->assertDatabaseHas('rooms', $room);

        $this->get(route('admin.rooms'))->assertSee($room['title']);
    }

    /**
     * Admin can update the room.
     * 
     * @return void
     */
    public function test_admin_can_update_any_room() 
    {
        $this->withoutExceptionHandling();
        
        $this->admin();

        $city = app(CityFactory::class)->withRooms(1)->create();
        
        $this->get(route('admin.rooms.edit', [$city->rooms->first()->path()]))->assertSee($city->rooms->first()->title);

        $city->rooms->first()->title = 'new title';
        $city->rooms->first()->city->id = 11;

        $this->patch(route('admin.rooms.update', [$city->rooms->first()->path()]), $city->rooms->first()->toArray())->assertRedirect(route('admin.rooms'));

        $this->assertDatabaseHas('rooms', [
            'title' => 'new title'
        ]);
    }


}
