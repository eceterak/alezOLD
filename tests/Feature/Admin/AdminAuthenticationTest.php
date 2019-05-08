<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\CityFactory;
use Facades\Tests\Setup\AdvertFactory;
use Facades\Tests\Setup\StreetFactory;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthorized_user_cannot_delete_cities()
    {
        $this->withoutExceptionHandling();

        $city = CityFactory::create();

        $this->delete(route('admin.cities.destroy', $city->slug))->assertRedirect(route('admin.login'));

        $this->actingAs($this->user())->delete(route('admin.cities.destroy', $city->slug))->assertRedirect(route('index'));
    }

    /** @test */
    public function guests_cannot_manage_cities() 
    {
        $city = CityFactory::create();

        $this->get(route('admin.cities'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.cities.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.edit', [$city->slug]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.cities.update', [$city->slug]), [])->assertRedirect(route('admin.login'));

        $this->signIn();

        $this->get(route('admin.cities'))->assertRedirect(route('index'));
        $this->get(route('admin.cities.create'))->assertRedirect(route('index'));
        $this->post(route('admin.cities.store'), [])->assertRedirect(route('index'));
        $this->get(route('admin.cities.edit', [$city->slug]))->assertRedirect(route('index'));
        $this->patch(route('admin.cities.update', [$city->slug]), [])->assertRedirect(route('index'));
    }

    /** @test */
    public function guests_cannot_manage_adverts() 
    {
        $advert = AdvertFactory::create();

        $this->get(route('admin.adverts'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.adverts.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.adverts.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.adverts.edit', [$advert->slug]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.adverts.update', [$advert->slug]), [])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function unauthorized_cannot_delete_adverts()
    {
        $advert = AdvertFactory::create();

        $this->delete(route('admin.adverts.destroy', $advert->id))->assertRedirect(route('admin.login'));

        $this->actingAs($this->user())->delete(route('admin.adverts.destroy', $advert->id))->assertRedirect(route('index'));
    }

    /** @test */
    public function unauthorized_cannot_delete_streets()
    {
        $street = StreetFactory::create();

        $this->delete(route('admin.streets.destroy', [$street->city->slug, $street->id]))->assertRedirect(route('admin.login'));

        $this->actingAs($this->user())->delete(route('admin.streets.destroy', [$street->city->slug, $street->id]))->assertRedirect(route('index'));
    }

}
