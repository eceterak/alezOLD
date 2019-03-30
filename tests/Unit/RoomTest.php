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
     * Room is always associated with city.
     * 
     * @return void
     */
    public function test_it_is_associated_with_a_city() 
    {
        $room = RoomFactory::create();

        $this->assertInstanceOf(City::class, $room->city);
    }

    /**
     * It has a path.
     *
     * @return void
     */
    public function test_it_has_a_path()
    {
        $room = RoomFactory::create();

        $this->assertEquals(preparePath($room->title.'-uid-'.$room->id), $room->path());
    }
    
    /**
     * Each room requires some attributes.
     *
     * @return void
     */
    public function test_room_requires_attributes() 
    {
        $this->user();

        $this->post(route('rooms.store'), [])->assertSessionHasErrors([
            'city_id', 'title', 'description', 'rent'
        ]);
    }
}
