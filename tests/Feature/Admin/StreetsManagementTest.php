<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\StreetFactory;
use Facades\Tests\Setup\CityFactory;
use App\Street;

class StreetsManagementTest extends TestCase
{

    use RefreshDatabase;

    // @test
    public function test_admin_can_create_a_street()
    {
        $this->admin();
        
        $city = CityFactory::create();

        $this->post(route('admin.streets.store', $city->slug), $attributes = factory(Street::class)->raw());

        $this->assertDatabaseHas('streets', $attributes);
    }

    // @test
    public function test_admin_can_view_streets_of_a_city()
    {
        $this->admin();

        $street = StreetFactory::create();

        $this->get(route('admin.cities.streets', $street->city->slug))->assertSee($street->name);
    }

    // @test
    public function test_admin_can_edit_a_street() 
    {
        $this->admin();

        $street = StreetFactory::create();

        $this->get(route('admin.streets.edit', [$street->city->slug, $street->id]))->assertSee($street->name);
    }

    // @test
    public function test_admin_can_update_a_street()
    {
        $this->admin();

        $street = StreetFactory::create();

        $this->post(route('admin.streets.update', [$street->city->slug, $street->id]), $attributes = factory(Street::class)->raw([
            'city_id' => $street->city->id
        ]));

        $this->assertDatabaseHas('streets', $attributes);
    }

}
