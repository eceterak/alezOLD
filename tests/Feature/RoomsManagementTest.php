<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Room;
use Facades\Tests\Setup\RoomFactory;
use Facades\Tests\Setup\CityFactory;

class RoomsManagementTest extends TestCase
{

    use WithFaker, RefreshDatabase;

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
        $this->user();

        $this->get(route('rooms.create'))->assertStatus(200);

        $city = CityFactory::create();
        
        $attributes = [
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
     * Authenticated user cant edit rooms of others.
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
}
