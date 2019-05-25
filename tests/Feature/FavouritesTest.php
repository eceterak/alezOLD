<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\Favourite;

class FavouritesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function guest_cannot_favourite_anything()
    {
        $advert = AdvertFactory::create();

        $this->post(route('adverts.favourite.store', [$advert->city->slug, $advert->slug]), [])->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_favourite_any_advert()
    {
        $this->signIn();

        $advert = AdvertFactory::create();

        $this->post(route('adverts.favourite.store', [$advert->city->slug, $advert->slug]));

        $favourite = Favourite::first();

        $this->assertEquals($advert->id, $favourite->advert->id);
    }

    /** @test */
    public function an_authenticated_user_may_favourite_advert_only_once()
    {
        $this->signIn();

        $advert = AdvertFactory::create();

        $this->post(route('adverts.favourite.store', [$advert->city->slug, $advert->slug]));
        $this->post(route('adverts.favourite.store', [$advert->city->slug, $advert->slug]));

        $this->assertCount(1, $advert->favourites);
    }

    /** @test */
    public function a_user_can_unfavourite_an_advert()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $advert = AdvertFactory::create();

        $advert->favourite();

        $this->delete(route('adverts.favourite.delete', [$advert->city->slug, $advert->slug]));

        $this->assertCount(0, $advert->favourites);
    }

    /** @test */
    public function a_user_can_view_her_favourites()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $advert = AdvertFactory::create();

        $advert->favourite();

        $this->get(route('favourites'))->assertSee($advert->title);
    }
}
