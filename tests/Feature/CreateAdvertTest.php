<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Mail\AdvertCreatedConfirmationMail;
use Facades\Tests\Setup\AdvertFactory;
use Illuminate\Support\Facades\Mail;
use App\Advert;
use App\Street;
use App\User;

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
        $this->signIn();

        $firstAdvert = AdvertFactory::create([
            'title' => 'hi ho lets go',
        ]);

        $this->assertEquals($firstAdvert->fresh()->slug, 'hi-ho-lets-go');

        $secondAdvert = AdvertFactory::create([
            'title' => 'hi ho lets go',
        ]);

        $this->assertEquals('hi-ho-lets-go-'.$secondAdvert->id, $secondAdvert->slug);
    }

    /** @test */
    public function user_can_create_an_advert()
    {   
        $this->actingAs($this->user())->get(route('adverts.create'))->assertStatus(200);

        $street = create(Street::class);
        
        $response = $this->post(route('adverts.store'), $attributes = raw(Advert::class, [
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ]))->assertRedirect(route('home'));
        
        Advert::where('title', $attributes['title'])->first();
        
        //dd($response->headers->get('Location'))
    }

    /** @test */
    public function email_is_sent_to_owner_after_adding_a_new_advert()
    {
        Mail::fake();

        $this->actingAs($this->user())->get(route('adverts.create'))->assertStatus(200);

        $street = create(Street::class);
        
        $this->post(route('adverts.store'), $attributes = raw(Advert::class, [
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ]))
        ->assertRedirect(route('home'));

        Mail::assertQueued(AdvertCreatedConfirmationMail::class);
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
        $this->withoutExceptionHandling();

        $this->signIn();

        $street = create(Street::class);
                
        $this->post(route('adverts.store'), $attributes = raw(Advert::class, [
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ]))->assertRedirect(route('home'));

        $this->expectException(\Exception::class);
                        
        $this->post(route('adverts.store'))->assertRedirect();
    }
}
