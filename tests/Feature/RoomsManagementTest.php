<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;
use App\Room;

class RoomsManagementTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * Guest cannot manage rooms.
     *
     * @return void
     */
    public function test_guest_cannot_manage_an_room() 
    {
        $room = factory(Room::class)->create();
        
        $this->post('/pokoje', $room->toArray())->assertredirect('/login');
        $this->get("/pokoje/edytuj/{$room->id}")->assertredirect('/login');
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_create_an_room()
    {
        $this->withoutExceptionHandling();
        
        $this->authenticated();

        $this->get('/pokoje/dodaj')->assertStatus(200);

        $city = factory(City::class)->create();
        
        $room = [
            'city_id' => $city->id,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'rent' => $this->faker->numberBetween(300, 1000)
        ];
        
        $this->post('/pokoje', $room)->assertRedirect('/pokoje');
        
        $this->assertDatabaseHas('rooms', $room);
        
        $this->get('/pokoje')->assertSee($room['title']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_edit_an_room() 
    {
        $this->withoutExceptionHandling();

        $this->authenticated();

        $room = factory(Room::class)->create(['user_id' => auth()->user()->id]);

        $this->get("/pokoje/edytuj/{$room->id}")
            ->assertSee($room->title)
            ->assertSee($room->description);
    }

    /**
     * 
     * 
     * @return
     */
    public function test_authenticated_user_cannot_edit_rooms_of_others() 
    {
        //$this->withoutExceptionHandling();

        $this->authenticated();

        $room = factory(Room::class)->create();

        $this->get("/pokoje/edytuj/{$room->id}")->assertStatus(403);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_room_requires_a_city() 
    {
        $this->authenticated();

        $attributes = factory(Room::class)->raw(['city_id' => '']);

        $this->post('/pokoje', $attributes)->assertSessionHasErrors('city_id');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_room_requires_a_title() 
    {
        $this->authenticated();

        $attributes = factory(Room::class)->raw(['title' => '']);

        $this->post('/pokoje', $attributes)->assertSessionHasErrors('title');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_room_requires_a_description() 
    {
        $this->authenticated();

        $attributes = factory(Room::class)->raw(['description' => '']);

        $this->post('/pokoje', $attributes)->assertSessionHasErrors('description');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_room_requires_a_rent() 
    {
        $this->authenticated();

        $attributes = factory(Room::class)->raw(['rent' => '']);

        $this->post('/pokoje', $attributes)->assertSessionHasErrors('rent');
    }
}
