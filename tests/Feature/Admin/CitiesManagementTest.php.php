<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\CityFactory;
use Facades\Tests\Setup\RoomFactory;
use App\City;

class CitiesManagementTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_admin_can_create_a_city() 
    {        
        $this->admin();

        $this->get(route('admin.cities.create'))->assertStatus(200);

        $this->post(route('admin.cities.store'), $attributes = factory(City::class)->raw())->assertRedirect(route('admin.cities'));

        $city = City::where($attributes)->first();
        
        $this->get(route('admin.cities'))->assertSee($attributes['name']);
        
        $this->get(route('admin.cities.edit', $city->slug))->assertStatus(200);
    }

    // @test
    public function test_admin_can_edit_a_city() 
    {
        $this->admin();

        $city = CityFactory::create();
        
        $this->get(route('admin.cities.edit', $city->slug))->assertSee($city->name);
    }

    // @test
    public function test_admin_can_update_a_city() 
    {
        $this->admin();

        $city = CityFactory::create();
        
        $this->get(route('admin.cities.edit', $city->slug))->assertSee($city->name);

        $this->patch(route('admin.cities.update', $city->slug), $attributes = factory(City::class)->raw())->assertRedirect(route('admin.cities'));

        $this->assertDatabaseHas('cities', $attributes);
    }

    // @test
    public function test_city_adverts_can_be_displayed()
    {
        $this->withoutExceptionHandling();

        $this->admin();

        $room = RoomFactory::create();

        $this->get(route('admin.cities.adverts', $room->city->slug))->assertSee($room->shortTitle());
    }

    // @test
    public function test_streets_of_a_city_can_be_displayed()
    {
        $this->admin();

        $street = RoomFactory::create();

        $this->get(route('admin.cities.streets', $street->city->slug))->assertSee($street->name);
    }

    // @test
    public function test_a_city_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->admin();

        $city = CityFactory::create();

        $this->delete(route('admin.cities.destroy', $city->id))->assertRedirect(route('admin.cities'));

        $this->assertDatabaseMissing('cities', $city->only('id'));
    }

    // @test
    public function test_unauthorized_cannot_delete_cities()
    {
        $city = CityFactory::create();

        $this->delete(route('admin.cities.destroy', $city->id))->assertRedirect(route('admin.login'));

        $this->user();

        $this->delete(route('admin.cities.destroy', $city->id))->assertRedirect(route('index'));
    }

    // @test
    public function test_guests_cannot_manage_cities() 
    {
        $city = CityFactory::create();

        $this->get(route('admin.cities'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.cities.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.edit', [$city->slug]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.cities.update', [$city->slug]), [])->assertRedirect(route('admin.login'));

        $this->user();

        $this->get(route('admin.cities'))->assertRedirect(route('index'));
        $this->get(route('admin.cities.create'))->assertRedirect(route('index'));
        $this->post(route('admin.cities.store'), [])->assertRedirect(route('index'));
        $this->get(route('admin.cities.edit', [$city->slug]))->assertRedirect(route('index'));
        $this->patch(route('admin.cities.update', [$city->slug]), [])->assertRedirect(route('index'));
    }
}
