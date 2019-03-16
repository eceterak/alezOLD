<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;

class CitiesTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * Admin can create a city.
     * 
     * @return test
     */
    public function test_admin_can_create_a_city() 
    {
        $this->withoutExceptionHandling();
        
        $this->authenticated(null, true); // Act as an admin.

        $this->get('/admin/miasta/dodaj')->assertStatus(200);

        $city = [
            'name' => $this->faker->city
        ];

        $this->post('/admin/miasta', $city)->assertRedirect('/admin/miasta');

        $this->assertDatabaseHas('cities', $city);

        $this->get('/admin/miasta')->assertSee($city['name']);
    }

    /**
     * Admin can edit a city.
     * 
     * @return test
     */
    public function test_admin_can_edit_a_city() 
    {
        //$this->withoutExceptionHandling();

        $this->authenticated(null, true);

        $city = factory(City::class)->create();

        $this->get('/admin/'.$city->name)->assertSee($city->name);
    }

    /**
     * Guests and non-admin users cannot create a city.
     * 
     * @return test
     */
    public function test_non_admin_cannot_create_a_city() 
    {
        $city = factory('App\City')->raw();

        // Guest
        $this->get('/admin/miasta/dodaj')->assertRedirect('/admin/login');
        $this->post('/admin/miasta', $city)->assertRedirect('/admin/login');

        $this->authenticated(); 

        // Non-admin
        $this->get('/admin/miasta/dodaj')->assertRedirect('/');
        $this->post('/admin/miasta', $city)->assertRedirect('/');
    }

    /**
     * Anyone can view a city.
     * 
     * @return test
     */
    public function test_guest_can_view_a_city() 
    {
        $this->withoutExceptionHandling();

        $city = factory('App\City')->create();

        $this->get("/{$city->path()}")->assertSee($city->name);
    }

}
