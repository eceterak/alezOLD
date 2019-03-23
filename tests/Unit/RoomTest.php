<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Room;
use App\City;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Room has to belong to an owner.
     *
     * @return void
     */
    public function test_it_belongs_to_an_owner()
    {
        $this->authenticated();

        $room = factory(Room::class)->create(['user_id' => auth()->id()]);

        $this->assertInstanceOf('App\User', $room->user);

        $this->assertEquals(auth()->user(), $room->user);
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
}
