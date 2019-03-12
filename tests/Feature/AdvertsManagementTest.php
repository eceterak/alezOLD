<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;
use App\Advert;

class AdvertsManagementTest extends TestCase
{

    use WithFaker, RefreshDatabase;
    
    /**
     * 
     * 
     * @return
    */
    public function test_city_can_have_adverts() 
    {
        $this->authenticated();

        $advert = auth()->user()->adverts()->create(
            factory(Advert::class)->raw()
        );

        $this->get($advert->city->path())->assertSee($advert['title']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_cannot_manage_an_advert() 
    {
        $advert = factory('App\Advert')->create();
        
        $this->post('/pokoje', $advert->toArray())->assertredirect('/login');
        $this->get("/pokoje/edytuj/{$advert->id}")->assertredirect('/login');
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_create_an_advert()
    {
        $this->withoutExceptionHandling();
        
        $this->authenticated();

        $this->get('/pokoje/dodaj')->assertStatus(200);

        $city = factory(City::class)->create();
        
        $advert = [
            'city_id' => $city->id,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'rent' => $this->faker->numberBetween(300, 1000)
        ];
        
        $this->post('/pokoje', $advert)->assertRedirect('/pokoje');
        
        $this->assertDatabaseHas('adverts', $advert);
        
        $this->get('/pokoje')->assertSee($advert['title']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_edit_an_advert() 
    {
        $this->withoutExceptionHandling();

        $this->authenticated();

        $advert = factory('App\Advert')->create(['user_id' => auth()->user()->id]);

        $this->get("/pokoje/edytuj/{$advert->id}")
            ->assertSee($advert->title)
            ->assertSee($advert->description);
    }

    /**
     * 
     * 
     * @return
     */
    public function test_authenticated_user_cannot_edit_adverts_of_others() 
    {
        //$this->withoutExceptionHandling();

        $this->authenticated();

        $advert = factory('App\Advert')->create();

        $this->get("/pokoje/edytuj/{$advert->id}")->assertStatus(403);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_advert_requires_a_city() 
    {
        $this->authenticated();

        $attributes = factory('App\Advert')->raw(['city_id' => '']);

        $this->post('/pokoje', $attributes)->assertSessionHasErrors('city_id');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_advert_requires_a_title() 
    {
        $this->authenticated();

        $attributes = factory('App\Advert')->raw(['title' => '']);

        $this->post('/pokoje', $attributes)->assertSessionHasErrors('title');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_advert_requires_a_description() 
    {
        $this->authenticated();

        $attributes = factory('App\Advert')->raw(['description' => '']);

        $this->post('/pokoje', $attributes)->assertSessionHasErrors('description');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_advert_requires_a_rent() 
    {
        $this->authenticated();

        $attributes = factory('App\Advert')->raw(['rent' => '']);

        $this->post('/pokoje', $attributes)->assertSessionHasErrors('rent');
    }
}
