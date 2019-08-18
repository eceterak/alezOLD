<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Mail\AdvertCreatedConfirmationMail;
use App\Mail\AdvertVerifiedConfirmationMail;
use Facades\Tests\Setup\AdvertFactory;
use Illuminate\Support\Facades\Mail;
use App\Advert;
use App\User;
use App\City;

class CreateAdvertTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_must_confirm_email_address_before_adding_a_new_advert()
    {
        $user = factory(User::class)->states('unconfirmed')->create();

        $this->actingAs($user)->get(route('adverts.create'))
            ->assertRedirect(route('verification.notice'));
    }

    /** @test */
    public function advert_requires_a_unique_slug()
    {
        $firstAdvert = AdvertFactory::create([
            'title' => 'hi ho lets go',
        ]);

        $this->assertEquals($firstAdvert->fresh()->slug, 'hi-ho-lets-go');

        $secondAdvert = AdvertFactory::create([
            'title' => 'hi ho lets go',
        ]);

        $this->assertNotEquals($firstAdvert->slug, $secondAdvert->slug);
    }

    /** @test */
    public function user_can_create_an_advert()
    {         
        $this->withoutExceptionHandling();
        
        $this->actingAs($this->user())->get(route('adverts.create'))->assertStatus(200);

        $city = create(City::class);
        
        $response = $this->post(route('adverts.store'), $attributes = raw(Advert::class, [
            'city_id' => $city->id
        ]))->assertRedirect(route('home'));
        
        Advert::where('title', $attributes['title'])->first();
    }

    /** @test */
    public function email_is_sent_to_owner_after_adding_a_new_advert()
    {
        Mail::fake();

        $city = create(City::class);
        
        $this->actingAs($this->user())->post(route('adverts.store'), $attributes = raw(Advert::class, [
            'city_id' => $city->id,
        ]))->assertRedirect(route('home'));

        Mail::assertQueued(AdvertCreatedConfirmationMail::class);
    }

    /** @test */
    public function email_is_sent_to_owner_after_advert_is_verified()
    {
        Mail::fake();
        
        $advert = AdvertFactory::create();

        $advert->verify();

        Mail::assertQueued(AdvertVerifiedConfirmationMail::class);
    }

    /** @test */
    public function guest_cannot_see_create_advert_page()
    {
        $this->get(route('adverts.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_create_advert()
    {
        $this->post(route('adverts.store', [1, 0]))->assertRedirect(route('login'));
    }

    /** @test */
    public function adverts_that_contain_spam_may_not_be_created()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        
        $this->expectException(\Exception::class);
        
        $this->post(route('adverts.store'), $attributes = raw(Advert::class, [
            'description' => 'spam message'
        ]));
    }

    /** @test */
    public function user_may_only_post_one_advert_per_minute()
    {
        $this->withoutExceptionHandling(); // Do not remove.

        $this->signIn();

        $city = create(City::class);
                
        $this->post(route('adverts.store'), $attributes = raw(Advert::class, [
            'city_id' => $city->id
        ]));

        $this->expectException(\Exception::class);
                        
        $this->post(route('adverts.store', [
            'cirt_id' => $city->id
        ]))->assertRedirect();
    }

    /** @test */
    public function if_user_has_added_phone_number_to_her_profile_it_is_visible_on_create_advert_page()
    {
        $user = $this->signIn();

        $user->phone = 500600700;

        $user->save();

        $this->get(route('adverts.create'))->assertSee($user->phone);
    }
}
