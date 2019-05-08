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

    /** @test */
    public function street_can_be_created()
    {
        $this->signInAdmin();
        
        $city = CityFactory::create();

        $this->get(action('Admin\CityStreetsController@create', $city->slug))->assertStatus(200);

        $this->post(route('admin.streets.store', $city->slug), $attributes = factory(Street::class)->raw());

        $street = Street::where($attributes)->first();

        $this->get(route('admin.cities.streets', $street->city->slug))->assertSee($street->name);
    }

    /** @test */
    public function street_can_be_updated()
    {
        $this->signInAdmin();

        $street = StreetFactory::create();

        $this->get(route('admin.streets.edit', [$street->city->slug, $street->id]))->assertSee($street->name);

        $this->patch(route('admin.streets.update', [$street->city->slug, $street->id]), $attributes = factory(Street::class)->raw([
            'city_id' => $street->city->id
        ]))
        ->assertRedirect(route('admin.cities.streets', $street->city->slug));

        $this->assertDatabaseHas('streets', $attributes);
    }

    /** @test */
    public function street_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $street = StreetFactory::create();

        $this->delete(route('admin.streets.destroy', [$street->city->slug, $street->id]))->assertRedirect(route('admin.cities.streets', $street->city->slug));

        $this->assertDatabaseMissing('streets', $street->only('id'));
    }
}
