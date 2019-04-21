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

    // Frontend tests

    // @test
    public function test_guest_cannot_manage_a_room() 
    {
        $room = RoomFactory::create();

        $this->get(route('rooms.mine'))->assertRedirect(route('login'));
        $this->get(route('rooms.create'))->assertRedirect(route('login'));
        $this->post(route('rooms.store'), [])->assertRedirect(route('login'));
        $this->get(route('rooms.edit', $room->path()))->assertRedirect(route('login'));
        $this->patch(route('rooms.update', $room->path()), [])->assertRedirect(route('login'));
    }
    
    // @test
    public function test_user_can_create_a_room()
    {   
        $this->user();

        $this->get(route('rooms.create'))->assertStatus(200);

        $city = CityFactory::create();

        $attributes = factory(Room::class)->raw([
            'city_id' => $city->id
        ]);
        
        $this->post(route('rooms.store'), $attributes)->assertRedirect(route('rooms'));

        /* $room = Room::where($attributes)->first();
        
        $this->get(route('rooms'))->assertSee($attributes['title']);

        $this->get(route('rooms.show', [$city->path(), $room->path()]))->assertSee($attributes['title']); */
    }

    // @test
    public function test_only_the_owner_of_the_room_can_update_it() 
    {
        $this->withoutExceptionHandling();

        $room = RoomFactory::create();

        $this->actingAs($room->user)->get(route('rooms.edit', $room->path()))
            ->assertSee($room->title)
            ->assertSee($room->description);

        $this->patch(route('rooms.update', $room->path()), $attributes = factory(Room::class)->raw([
            'user_id' => $room->user->id,
            'city_id' => $room->city->id,
            'title' => 'updated'
        ]))->assertRedirect(route('rooms'));

        $this->assertDatabaseHas('rooms', $attributes);
    }

    // @test
    public function test_authenticated_user_cant_edit_rooms_of_others() 
    {
        $this->user();

        $room = RoomFactory::create();

        $this->get(route('rooms.edit', $room->path()))->assertStatus(403);

        $this->patch(route('rooms.update', $room->path()), [])->assertStatus(403);
    }

    // @test
    public function test_guest_can_view_a_room() 
    {        
        $room = RoomFactory::create();

        $this->get(route('rooms'))->assertSee($room->title);

        $this->get(route('rooms.show', [$room->city->path(), $room->path()]))->assertSee($room->title);
    }

    // Backend tests

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
