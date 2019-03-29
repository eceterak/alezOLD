<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;
use Facades\Tests\Setup\CityFactory;

class CitiesManagementTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * Guest shouldn't have any permissions to manage a cities.
     * 
     * @return void
     */
    public function test_guests_cannot_manage_cities() 
    {
        $city = CityFactory::create();

        $this->get(route('admin.cities'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.cities.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.edit', [$city->path()]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.cities.update', [$city->path()]), [])->assertRedirect(route('admin.login'));
    }

    /**
     * Admin can create a city.
     * 
     * @return void
     */
    public function test_admin_can_create_a_city() 
    {        
        $this->admin();

        $this->get(route('admin.cities.create'))->assertStatus(200);

        $attributes = [
            'name' => 'brzeszcze'
        ];

        $this->post(route('admin.cities'), $attributes)->assertRedirect(route('admin.cities'));

        $city = City::where($attributes)->first();
        
        $this->get(route('admin.cities'))->assertSee($attributes['name']);
        
        $this->get(route('admin.cities.edit', $city->path()))->assertStatus(200);
    }

    /**
     * Admin can update a city.
     * 
     * @return void
     */
    public function test_admin_can_update_a_city() 
    {
        $city = CityFactory::withRooms(1)->ownedBy($this->admin())->create();
        
        $this->get(route('admin.cities.edit', $city->path()))->assertSee($city->name);

        $this->patch(route('admin.cities.update', $city->path()), $attributes = [
            'name' => 'changed'
        ])->assertRedirect(route('admin.cities'));

        $this->assertDatabaseHas('cities', $attributes);
    }
}
