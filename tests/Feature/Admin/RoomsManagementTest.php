<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Room;

class RoomsManagementTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * Admin can create an room.
     * 
     * @return test
     */
    public function test_admin_can_create_an_room()
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
     * Admin have permissions to edit an room.
     * 
     * @return
     */
    public function test_admin_can_edit_any_room() 
    {
        $this->withoutExceptionHandling();
        
        $this->authenticated(null, true);

        $room = factory(Room::class)->create();
        
        $this->get(route('admin.rooms.edit', [$room->city->name, $room->id]))->assertSee($room->title);
    }


}
