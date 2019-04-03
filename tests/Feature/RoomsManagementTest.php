<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\RoomFactory;
use Facades\Tests\Setup\CityFactory;
use App\Room;

class RoomsManagementTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    // User tests

    /**
     * Guest cannot manage rooms.
     *
     * @return void
     */
    public function test_guest_cannot_manage_a_room() 
    {
        $room = RoomFactory::create();

        $this->get(route('rooms.mine'))->assertRedirect(route('login'));
        $this->get(route('rooms.create'))->assertRedirect(route('login'));
        $this->post(route('rooms.store'), [])->assertRedirect(route('login'));
        $this->get(route('rooms.edit', $room->path()))->assertRedirect(route('login'));
        $this->patch(route('rooms.update', $room->path()), [])->assertRedirect(route('login'));
    }
    
    /**
     * Authenticated user can create a new rom.
     *
     * @return void
     */
    public function test_user_can_create_a_room()
    {   
        $this->withoutExceptionHandling();

        $this->user();

        $this->get(route('rooms.create'))->assertStatus(200);

        $city = CityFactory::create();

        $attributes = [
            'place_id' => $this->faker->sha1,
            'city_id' => $city->id,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'rent' => $this->faker->numberBetween(300, 1000)
        ];
        
        $this->post(route('rooms.store'), $attributes)->assertRedirect(route('rooms'));

        $room = Room::where($attributes)->first();
        
        $this->get(route('rooms'))->assertSee($attributes['title']);

        $this->get(route('rooms.show', [$city->path(), $room->path()]))->assertSee($attributes['title']);
    }

    /**
     * Only the owner of the room can update it.
     *
     * @return void
     */
    public function test_only_the_owner_of_the_room_can_update_it() 
    {
        $room = RoomFactory::create();

        $this->actingAs($room->user)->get(route('rooms.edit', $room->path()))
            ->assertSee($room->title)
            ->assertSee($room->description);

        $this->patch(route('rooms.update', $room->path()), $attributes = [
            'title' => 'updated',
            'description' => $room->description,
            'rent' => $room->rent,
            'city_id' => $room->city->id
        ])->assertRedirect(route('rooms'));

        $this->assertDatabaseHas('rooms', $attributes);
    }

    /**
     * Authenticated user can't edit rooms of others.
     *
     * @return void
     */
    public function test_authenticated_user_cant_edit_rooms_of_others() 
    {
        $this->user();

        $room = RoomFactory::create();

        $this->get(route('rooms.edit', $room->path()))->assertStatus(403);

        $this->patch(route('rooms.update', $room->path()), [])->assertStatus(403);
    }

    /**
     * Anyone can view a room.
     * 
     * @return void
     */
    public function test_guest_can_view_a_room() 
    {        
        $room = RoomFactory::create();

        $this->get(route('rooms'))->assertSee($room->title);

        $this->get(route('rooms.show', [$room->city->path(), $room->path()]))->assertSee($room->title);
    }

    // Admin tests

    /**
     * Guest shouldn't have any permissions to manage rooms.
     * 
     * @return void
     */
    public function test_guests_cannot_manage_rooms() 
    {
        $room = RoomFactory::create();

        $this->get(route('admin.rooms'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.rooms.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.rooms.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.rooms.edit', [$room->path()]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.rooms.update', [$room->path()]), [])->assertRedirect(route('admin.login'));
    }

    /**
     * Admin can create a room.
     * 
     * @return void
     */
    public function test_admin_can_create_a_room()
    {
        $this->withoutExceptionHandling();

        $city = CityFactory::create();

        $this->admin();

        $attributes = factory(Room::class)->raw([
            'user_id' => auth()->user()->id, 'city_id' => $city->id
        ]);

        $this->post(route('admin.rooms.store', $attributes))->assertRedirect(route('admin.rooms'));

        $room = Room::where($attributes)->first();

        $this->get(route('admin.rooms.edit', $room->path()))->assertSee($attributes['title']);
    }

    /**
     * Admin can update the room.
     * 
     * @return void
     */
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
