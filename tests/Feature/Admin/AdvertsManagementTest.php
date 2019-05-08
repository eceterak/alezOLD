<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use Facades\Tests\Setup\StreetFactory;
use App\Advert;

class AdvertsManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_an_advert()
    {
        $this->signInAdmin();

        $street = StreetFactory::create();

        $this->get(action('Admin\AdvertsController@create'))->assertStatus(200);

        $this->post(route('admin.adverts.store', $attributes = factory(Advert::class)->raw([
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ])))
        ->assertRedirect(route('admin.adverts'));

        $advert = Advert::where($attributes)->first();

        $this->get(route('admin.adverts'))->assertSee($advert->shortTitle());
    }

    /** @test */
    public function admin_can_update_any_advert() 
    {   
        $this->signInAdmin();

        $advert = AdvertFactory::create();

        $this->get(route('admin.adverts.edit', $advert->slug))->assertSee($advert->title);

        $this->patch(route('admin.adverts.update', [$advert->slug]), $attributes = factory(Advert::class)->raw([
            'city_id' => $advert->city->id,
            'street_id' => $advert->street->id
        ]))
        ->assertRedirect(route('admin.adverts'));

        $this->assertDatabaseHas('adverts', $attributes);
    }

    /** @test */
    public function admin_can_delete_any_advert()
    {
        $this->signInAdmin();

        $advert = AdvertFactory::create();

        $this->delete(route('admin.adverts.destroy', $advert->id))->assertRedirect(route('admin.adverts'));

        $this->assertDatabaseMissing('adverts', $advert->only('id'));
    }
}
