<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;

class ReadAdvertsTest extends TestCase
{
    use RefreshDatabase;

    protected $advert;

    public function setUp()
    {
        parent::setUp();

        $this->advert = AdvertFactory::create();
    }

    /** @test */
    public function a_user_can_view_all_verified_adverts()
    {
        $this->get(route('adverts'))->assertSeeText($this->advert->title);
    }

    /** @test */
    public function unverified_adverts_should_not_be_listed()
    {
        $advert = AdvertFactory::create([
            'verified' => false
        ]);

        $this->get(route('adverts'))->assertDontSee($advert->title);
    }

    /** @test */
    public function archived_adverts_are_should_not_be_listed()
    {
        $this->advert->archive();

        $this->get(route('adverts'))->assertDontSee($this->advert->title);
    }

    /** @test */
    public function a_user_can_view_a_single_advert()
    {        
        $this->get(route('adverts.show', [$this->advert->city->slug, $this->advert->slug]))->assertSee($this->advert->title);
    }

    /** @test */
    public function unverified_advert_should_not_be_accessible()
    {
        $advert = AdvertFactory::create([
            'verified' => false
        ]);

        $this->get(route('adverts.show', [$advert->city->slug, $advert->slug]))->assertStatus(403);
    }

    /** @test */
    public function a_user_can_see_her_advert_even_if_it_is_still_unverified()
    {
        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create([
            'verified' => false
        ]);

        $this->get(route('adverts.show', [$advert->city->slug, $advert->slug]))->assertSeeText($advert->title);
    }

    /** @test */
    public function ajax_can_request_adverts_from_a_city()
    {
        $response = $this->getJson(route('ajax.city.adverts', $this->advert->city->slug))->json();

        $this->assertCount(1, $response['data']);
    }

    /** @test */
    public function record_a_new_visit_each_time_the_advert_is_read()
    {
        $advert = AdvertFactory::create();

        $this->call('GET', route('adverts.show', [$advert->city->slug, $advert->slug]));

        $this->assertEquals(1, $advert->fresh()->visits);
    }

    /** @test */
    public function a_user_can_view_her_adverts()
    {
        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        $archivedAdvert = AdvertFactory::ownedBy($user)->create([
            'archived' => true
        ]);

        $this->get(route('home'))->assertSeeText($advert->title)->assertDontSee($archivedAdvert->title);
    }

    /** @test */
    public function a_user_can_view_her_archived_adverts()
    {
        $user = $this->signIn();

        $archivedAdvert = AdvertFactory::ownedBy($user)->create([
            'archived' => true
        ]);

        $this->get(route('archives'))->assertSeeText($archivedAdvert->title);
    }

    /** @test */
    public function phone_number_can_be_fetch_when_reading_an_advert()
    {
        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create([
            'phone' => 600500300
        ]);

        $response = $this->json('GET', route('api.adverts.phone', $advert->slug))->decodeResponseJson();

        $this->assertEquals('600 500 300', $response['phone']);
    }

    /** @test */
    /* public function if_user_hides_her_phone_number_it_wont_be_visible_when_looking_at_advert()
    {
        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        $this->get(route('adverts.show', [$advert->city->slug, $advert->slug]))->assertSee($user->phone);

        $user->hide_phone = true;
        $user->save();

        $this->get(route('adverts.show', [$advert->city->slug, $advert->slug]))->assertDontSeeText('Telefon');
    } */
}
