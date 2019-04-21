<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Street;
use Facades\Tests\Setup\StreetFactory;
use Facades\Tests\Setup\CityFactory;

class StreetsManagementTest extends TestCase
{

    use RefreshDatabase;

    // @test
    public function test_admin_can_create_a_street()
    {
        $this->admin();

        $city = CityFactory::create();

        $this->post(route('admin.streets.store', $city->path()), $attributes = factory(Street::class)->raw());

        $this->assertDatabaseHas('streets', $attributes);
    }

    // @test
    public function test_admin_can_view_streets_of_a_city()
    {
        $this->withoutExceptionHandling();

        $this->admin();

        $street = StreetFactory::create();

        $this->get(route('admin.cities.streets', $street->city->path()))->assertSee($street->name);
    }

    // @test
    public function test_admin_can_edit_a_street() 
    {
        $this->admin();

        $street = StreetFactory::create();

        $this->get(route('admin.streets.edit', [$street->city->path(), $street->path()]))->assertSee($street->name);
    }

    // @test
    public function test_admin_can_update_a_street()
    {
        $this->admin();

        $street = StreetFactory::create();

        $this->post(route('admin.streets.update', [$street->city->path(), $street->path()]), $attributes = factory(Street::class)->raw([
            'city_id' => $street->city->id
        ]));

        $this->assertDatabaseHas('streets', $attributes);
    }

}
