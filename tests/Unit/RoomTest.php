<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Room;
use App\City;
use Facades\Tests\Setup\RoomFactory;
use Illuminate\Support\Facades\Auth;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Room belongs to an owner.
     *
     * @return void
     */
    public function test_it_belongs_to_an_owner()
    {
        $room = RoomFactory::ownedBy($this->user())->create();

        $this->assertInstanceOf('App\User', $room->user);

        $this->assertEquals(auth()->user()->id, $room->user->id);
    }

    /**
     * Room is always associated with one city.
     * 
     * @return void
     */
    public function test_it_is_associated_with_a_city() 
    {
        $room = factory(Room::class)->create();

        $this->assertInstanceOf(City::class, $room->city);
    }

    /**
     * 
     *
     * @return void
     */
    public function test_it_has_a_path()
    {
        $room = factory(Room::class)->create();

        $this->assertEquals('/'.preparePath($room->city->name).'/'.preparePath($room->title), $room->path());
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
