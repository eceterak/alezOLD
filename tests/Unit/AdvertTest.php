<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\Advert;
use App\City;
use Carbon\Carbon;
use App\Photo;
use App\Street;

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
    public function it_must_be_unverified_by_default()
    {
        $this->signIn();

        $street = create(Street::class);
        
        $this->post(route('adverts.store'), $attributes = raw(Advert::class, [
            'city_id' => $street->city->id,
            'street_id' => $street->id,
        ]))->assertRedirect(route('home'));

        $advert = Advert::where('title', $attributes['title'])->first();

        $this->assertFalse($advert->verified);
    }

    /** @test */
    public function it_can_be_verified()
    {
        $advert = AdvertFactory::create([
            'verified' => false
        ]);
        
        $advert->verify();

        $this->assertTrue($advert->refresh()->verified);
    }

    /** @test */
    public function it_can_be_archived()
    {
        $this->advert->archive();

        $this->assertTrue($this->advert->refresh()->archived);
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

    /** @test */
    public function it_can_determine_its_featured_image()
    {
        $advert = AdvertFactory::create();
        
        $this->assertEquals('/storage/photos/notfound.jpg', $advert->featured_photo_path);
        
        $photo = Photo::create([
            'advert_id' => $advert->id,
            'url' => 'photos/room.jpg',
            'order' => 0
        ]);
        
        $this->assertEquals('/storage/photos/room.jpg', $advert->featured_photo_path);
    }

    /** @test */
    public function it_can_check_for_pending_revision()
    {
        $advert = AdvertFactory::create();

        $advert->revision = [
            'title' => 'foo',
            'description' => 'bar'
        ];
        
        $this->assertTrue($advert->has_pending_revision);
    }

    /** @test */
    public function it_can_update_its_current_attributes_with_revision()
    {
        $advert = AdvertFactory::create();

        $advert->revision = [
            'title' => 'foo',
            'description' => 'bar'
        ];

        $advert->loadPendingRevision();
        
        $this->assertEquals($advert->title, 'foo');
        $this->assertNotEquals($advert->fresh()->title, 'foo');
    }

    /** @test */
    public function it_can_accept_pending_revisions()
    {
        $advert = AdvertFactory::create();

        $advert->revision = [
            'title' => 'foo',
            'description' => 'bar'
        ];

        $advert->acceptRevision();
        
        $this->assertEquals($advert->fresh()->title, 'foo');
    }

    /** @test */
    public function if_advert_is_deleted_its_name_reflects_that_fact()
    {
        $advert = AdvertFactory::create();

        $title = $advert->title;

        $advert->archive();

        $this->assertEquals($title.' (zakończone)', $advert->fresh()->title);
    }
}
