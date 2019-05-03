<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\RoomFactory;
use Facades\Tests\Setup\StreetFactory;
use App\Room;

class UserRoomsManagementTest extends TestCase
{

    use RefreshDatabase;

    // @test
    public function test_guest_cannot_manage_a_room() 
    {
        $room = RoomFactory::create();

        $this->get(route('rooms.mine'))->assertRedirect(route('login'));
        $this->get(route('rooms.create'))->assertRedirect(route('login'));
        $this->post(route('rooms.store'), [])->assertRedirect(route('login'));
        $this->get(route('rooms.edit', $room->slug))->assertRedirect(route('login'));
        $this->patch(route('rooms.update', $room->slug), [])->assertRedirect(route('login'));
    }
    
    // @test
    public function test_user_can_create_a_room()
    {   
        $this->user();

        $this->get(route('rooms.create'))->assertStatus(200);

        $street = StreetFactory::create();

        $attributes = factory(Room::class)->raw([
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ]);
        
        $this->post(route('rooms.store'), $attributes)->assertRedirect(route('home'));

        $room = Room::where($attributes)->first();
        
        $this->get(route('rooms'))->assertSee($attributes['title']);

        $this->get(route('rooms.show', [$street->city->slug, $room->slug]))->assertSee($attributes['title']);
    }

    // @test
    public function test_only_the_owner_of_the_room_can_update_it() 
    {
        $this->withoutExceptionHandling();

        $room = RoomFactory::create();

        $this->actingAs($room->user)->get(route('rooms.edit', $room->slug));

        $this->patch(route('rooms.update', $room->slug), $attributes = factory(Room::class)->raw([
            'city_id' => $room->city->id,
            'street_id' => $room->city->id,
            'title' => 'updated'
        ]))->assertRedirect(route('rooms'));

        $this->assertDatabaseHas('rooms', $attributes);
    }

    // @test
    public function test_authenticated_user_cant_edit_rooms_of_others() 
    {
        $this->user();

        $room = RoomFactory::create();

        $this->get(route('rooms.edit', $room->slug))->assertStatus(403);

        $this->patch(route('rooms.update', $room->slug), [])->assertStatus(403);
    }

    // @test
    public function test_guest_can_view_a_room() 
    {        
        $room = RoomFactory::create();

        $this->get(route('rooms'))->assertSee($room->title);

        $this->get(route('rooms.show', [$room->city->slug, $room->slug]))->assertSee($room->title);
    }

    // @test
    public function test_a_owner_of_the_room_can_delete_it()
    {
        $room = RoomFactory::create();

        $this->actingAs($room->user)->delete(route('rooms.destroy', $room->id))->assertRedirect(route('home'));

        $this->assertDatabaseMissing('rooms', $room->only('id'));
    }

    // @test
    public function test_unauthorized_cannot_delete_projects()
    {
        $room = RoomFactory::create();

        $this->delete(route('rooms.destroy', $room->id))->assertRedirect(route('login'));

        $this->user();

        $this->delete(route('rooms.destroy', $room->id))->assertStatus(403);
    }
}
