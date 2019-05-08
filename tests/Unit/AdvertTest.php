<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\TemporaryAdvert;
use App\Advert;
use App\City;

class AdvertTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->advert = AdvertFactory::create();
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $advert = AdvertFactory::ownedBy($this->signIn())->create();

        $this->assertInstanceOf('App\User', $advert->user);

        $this->assertEquals(auth()->user()->id, $advert->user->id);
    }

    /** @test */
    public function it_has_belongs_to_a_city() 
    {
        $this->assertInstanceOf(City::class, $this->advert->city);
    }
    
    /** @test */
    public function it_has_a_slug()
    {
        $this->assertEquals(str_slug($this->advert->title.'-uid-'.$this->advert->id), $this->advert->slug);
    }

    /** @test */
    public function it_requires_a_title() 
    {
        $this->actingAs($this->user())->post(route('adverts.store'), factory(Advert::class)->raw([
        'title' => null
        ]))
        ->assertSessionHasErrors('title');
    }

    /** @test */
    public function it_requires_a_rent() 
    {
        $this->actingAs($this->user())->post(route('adverts.store'), factory(Advert::class)->raw([
        'rent' => null
        ]))
        ->assertSessionHasErrors('rent');
    }

    /** @test */
    public function it_requires_a_valid_city() 
    {
        $city = factory(City::class)->create();

        $this->actingAs($this->user())->post(route('adverts.store'), factory(Advert::class)->raw([
        'city_id' => null
        ]))
        ->assertSessionHasErrors('city_id');

        $this->actingAs($this->user())->post(route('adverts.store'), factory(Advert::class)->raw([
        'city_id' => 9999
        ]))
        ->assertSessionHasErrors('city_id');
    }

    /** @test */
    public function it_requires_a_description() 
    {
        $this->actingAs($this->user())->post(route('adverts.store'), factory(Advert::class)->raw([
        'description' => null
        ]))
        ->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_can_be_verified()
    {
        $this->actingAs($this->admin())->patch(route('admin.adverts.update', $this->advert->slug), [
            'verified' => true
        ]);

        $this->assertTrue($this->advert->refresh()->verified);
    }

    /** @test */
    public function it_can_start_a_conversation()
    {
        $this->signIn();

        $this->advert->inquiry('hi');

        $this->assertCount(1, $this->advert->conversations);
    }

    /** @test */
    public function it_can_create_a_temporary_advert()
    {
        Advert::temporary();

        $this->assertCount(1, TemporaryAdvert::all());
    }
}
