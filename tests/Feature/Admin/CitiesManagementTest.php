<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\CityFactory;
use Facades\Tests\Setup\AdvertFactory;
use App\City;

class CitiesManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function city_can_be_created() 
    {        
        $this->signInAdmin();

        $this->get(action('Admin\CitiesController@create'))->assertStatus(200);

        $this->post(route('admin.cities.store'), $attributes = factory(City::class)->raw())->assertRedirect(route('admin.cities'));

        $city = City::where($attributes)->first();
        
        $this->get(route('admin.cities'))->assertSee($city->name);
    }

    /** @test */
    public function city_can_be_updated() 
    {
        $this->signInAdmin();

        $city = CityFactory::create();
        
        $this->get(route('admin.cities.edit', $city->slug))->assertSee($city->name);

        $this->patch(route('admin.cities.update', $city->slug), $attributes = factory(City::class)->raw())->assertRedirect(route('admin.cities'));

        $this->assertDatabaseHas('cities', $attributes);
    }

    /** @test */
    public function adverts_from_city_can_be_displayed()
    {
        $this->signInAdmin();

        $advert = AdvertFactory::create();

        $this->get(route('admin.cities.adverts', $advert->city->slug))->assertSee($advert->shortTitle());
    }

    /** @test */
    public function streets_of_a_city_can_be_displayed()
    {
        $this->signInAdmin();

        $street = AdvertFactory::create();

        $this->get(route('admin.cities.streets', $street->city->slug))->assertSee($street->name);
    }

    /** @test */
    public function city_can_be_deleted()
    {
        $this->signInAdmin();

        $city = CityFactory::create();

        $this->delete(route('admin.cities.destroy', $city->slug))->assertRedirect(route('admin.cities'));

        $this->assertDatabaseMissing('cities', $city->only('id'));
    }
}