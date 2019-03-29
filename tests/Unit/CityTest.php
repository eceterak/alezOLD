<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;
use App\Room;
use Facades\Tests\Setup\CityFactory;

class CityTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * City requires a name.
     * 
     * @return void
     */
    public function test_city_requires_a_name()
    {
        $this->admin();

        $city = factory(City::class)->raw(['name' => '']);

        $this->post('/admin/miasta', $city)->assertSessionHasErrors('name');
    }

    /**
     * City has a path.
     * 
     * @return void
     */
    public function test_city_has_a_path() 
    {
        $city = factory(City::class)->create();
        
        $this->assertEquals(preparePath($city->name), $city->path());
    }

    /**
     * City can have rooms.
     * 
     * @return void
     */
    public function test_city_can_have_rooms() 
    {
        $this->withExceptionHandling();

        $city = CityFactory::create();

        $room = factory(Room::class)->raw([
            'title' => 'short title',
            'user_id' => $this->user()
        ]);

        $city->rooms()->create($room);

        $this->get(route('admin.cities.edit', $city->path()))->assertSee($room['title']);
    }
}
