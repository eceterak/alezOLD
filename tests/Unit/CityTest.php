<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;
use App\Room;

class CityTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * City has a path.
     * 
     * @return test
     */
    public function test_city_has_a_path() 
    {
        $city = factory(City::class)->create();

        $name = strtolower(str_replace(' ', '-', ($city->name)));
        
        $this->assertEquals("/{$name}", $city->path());
    }

    /**
     * City requires a name.
     * 
     * @return test
     */
    public function test_city_requires_a_name()
    {
        $this->authenticated(null, true);

        $city = factory(City::class)->raw(['name' => '']);

        $this->post('/admin/miasta', $city)->assertSessionHasErrors('name');
    }

    /**
     * City can have rooms.
     * 
     * @return test
     */
    public function test_city_can_have_rooms() 
    {
        $this->authenticated();

        $room = auth()->user()->rooms()->create(
            factory(Room::class)->raw()
        );

        dd($room->city->path());

        $this->get($room->city->path())->assertSee($room['title']);
    }
}
