<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Street;
use App\City;

class StreetsManagementTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function street_can_be_created()
    {
        $this->signInAdmin();
        
        $city = create(City::class);

        $this->get(action('Admin\CityStreetsController@create', $city->slug))->assertStatus(200);

        $this->post(route('admin.streets.store', $city->slug), $attributes = raw(Street::class));

        $street = Street::whereName($attributes['name'])->first();

        $this->get(route('admin.cities.streets', $street->city->slug))->assertSee($street->name);
    }

    /** @test */
    public function street_can_be_updated()
    {
        $this->signInAdmin();

        $street = create(Street::class);

        $this->get(route('admin.streets.edit', [$street->city->slug, $street->id]))->assertSee($street->name);

        $this->patch(route('admin.streets.update', [$street->city->slug, $street->id]), $attributes = raw(Street::class, [
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

        $street = create(Street::class);

        $this->delete(route('admin.streets.destroy', [$street->city->slug, $street->id]))->assertRedirect(route('admin.cities.streets', $street->city->slug));

        $this->assertDatabaseMissing('streets', $street->only('id'));
    }
}
