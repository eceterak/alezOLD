<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\Advert;
use App\City;
use Carbon\Carbon;

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
        $this->assertEquals(str_slug($this->advert->title), $this->advert->slug);
    }

    /** @test */
    public function it_requires_a_title() 
    {
        $this->actingAs($this->user())->post(route('adverts.store'))
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function it_requires_a_rent() 
    {
        $this->actingAs($this->user())->post(route('adverts.store'))
            ->assertSessionHasErrors('rent');
    }

    /** @test */
    public function it_requires_a_valid_city() 
    {
        $city = create(City::class);

        $this->actingAs($this->user())->post(route('adverts.store'))
            ->assertSessionHasErrors('city_id');

        $this->actingAs($this->user())->post(route('adverts.store'), raw(Advert::class, [
        'city_id' => 9999
        ]))->assertSessionHasErrors('city_id');
    }

    /** @test */
    public function it_requires_a_description() 
    {
        $this->actingAs($this->user())->post(route('adverts.store'))
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
    public function it_can_check_if_is_favourited_by_current_user()
    {
        $this->signIn();

        $this->advert->favourite();

        $this->assertTrue($this->advert->isFavourited());
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {
        $advert = AdvertFactory::create();
        
        $this->assertTrue($advert->wasJustPublished());
        
        $advert->created_at = Carbon::now()->subMonth();

        $this->assertFalse($advert->wasJustPublished());
    }
}
