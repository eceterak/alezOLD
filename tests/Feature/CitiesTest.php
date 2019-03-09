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
     * 
     * 
     */
    public function test_user_can_create_a_city() 
    {
        $this->withExceptionHandling();

        $this->authenticated();

        $this->get('/miasta/dodaj')->assertStatus(200);

        $city = [
            'name' => $this->faker->city
        ];

        $this->post('/miasta', $city)->assertRedirect('/miasta');

        $this->assertDatabaseHas('cities', $city);

        $this->get('/miasta')->assertSee($city['name']);
    }

    /**
     * 
     * 
     */
    public function test_user_can_edit_an_city() 
    {
        $this->withoutExceptionHandling();

        $this->authenticated();

        $city = factory('App\City')->create();

        $this->get($city->name.'/edytuj')->assertSee($city->name);
    }

    /**
     * 
     * 
     */
    public function test_city_requires_a_name()
    {
        $this->authenticated();

        $city = factory(City::class)->raw(['name' => '']);

        $this->post('/miasta', $city)->assertSessionHasErrors('name');
    }

    /**
     * 
     * 
     */
    public function test_guest_cannot_create_a_city() 
    {
        $city = factory('App\City')->create();

        $this->get('/miasta/dodaj')->assertRedirect('/login');
        $this->post('/miasta', $city->toArray())->assertRedirect('/login');
    }

    /**
     * 
     * 
     */
    public function test_guest_can_view_a_city() 
    {
        $this->withoutExceptionHandling();

        $city = factory('App\City')->create();

        $this->get("/{$city->path()}")->assertSee($city->name);
    }

}
