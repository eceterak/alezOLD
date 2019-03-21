<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;

class CitiesManagementTest extends TestCase
{

    use WithFaker ,RefreshDatabase;

    /**
     * Admin can create a city.
     * 
     * @return void
     */
    public function test_admin_can_create_a_city() 
    {
        //$this->withoutExceptionHandling();
        
        $this->authenticated(null, true); // Act as an admin.

        $this->get(route('admin.cities.create'))->assertStatus(200);

        $city = [
            'name' => $this->faker->city
        ];

        $this->post(route('admin.cities'), $city)->assertRedirect(route('admin.cities'));

        $this->assertDatabaseHas('cities', $city);

        $this->get(route('admin.cities'))->assertSee($city['name']);
    }

    /**
     * Admin can edit a city.
     * 
     * @return void
     */
    public function test_admin_can_edit_a_city() 
    {
        $this->withoutExceptionHandling();

        $this->authenticated(null, true);

        $city = factory(City::class)->create();

        $this->get(route('admin.cities.edit', $city->name))->assertSee($city->name);
    }

    /**
     * Guests and non-admin users cannot create a city.
     * 
     * @return void
     */
    public function test_non_admin_cannot_create_a_city() 
    {
        $city = factory('App\City')->raw();

        // Guest
        $this->get(route('admin.cities.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.cities.store', $city))->assertRedirect(route('admin.login'));

        $this->authenticated(); 

        // Non-admin
        $this->get(route('admin.cities.create'))->assertRedirect('/');
        $this->post(route('admin.cities'), $city)->assertRedirect('/');
    }
}
