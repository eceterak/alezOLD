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
        $this->assertTrue($this->advert->wasJustPublished());
        
        $this->advert->created_at = Carbon::now()->subMonth();

        $this->assertFalse($this->advert->wasJustPublished());
    }

    /** @test */
    public function it_can_determine_its_featured_image()
    {        
        $this->assertEquals('/storage/photos/notfound.jpg', $this->advert->featured_photo_path);
        
        $photo = Photo::create([
            'advert_id' => $this->advert->id,
            'url' => 'photos/room.jpg',
            'order' => 0
        ]);
        
        $this->assertEquals('https://alez.s3.eu-central-1.amazonaws.com/photos/room.jpg', $this->advert->featured_photo_path);
    }

    /** @test */
    public function it_can_be_revised()
    {
        $attributes = [
            'title' => 'foo'
        ];

        $this->advert->revise($attributes);

        $this->assertEquals($this->advert->fresh()->revision, $attributes);
    }

    /** @test */
    public function it_can_check_for_pending_revision()
    {
        $this->advert->revision = [
            'title' => 'foo',
            'description' => 'bar'
        ];
        
        $this->assertTrue($this->advert->has_pending_revision);
    }

    /** @test */
    public function it_can_update_its_current_attributes_with_revision()
    {
        $this->advert->revision = [
            'title' => 'foo',
            'description' => 'bar'
        ];

        $this->advert->loadPendingRevision();
        
        $this->assertEquals($this->advert->title, 'foo');
        $this->assertNotEquals($this->advert->fresh()->title, 'foo');
    }

    /** @test */
    public function it_can_accept_pending_revisions()
    {
        $this->advert->revision = [
            'title' => 'foo',
            'description' => 'bar'
        ];

        $this->advert->acceptRevision();
        
        $this->assertEquals($this->advert->fresh()->title, 'foo');

        $this->assertNull($this->advert->fresh()->revision);
    }

    /** @test */
    public function it_can_reject_pending_revisions()
    {
        $this->advert->revision = [
            'title' => 'foo',
        ];

        $this->advert->rejectRevision();
        
        $this->assertEquals($this->advert->fresh()->title, $this->advert->title);

        $this->assertNull($this->advert->fresh()->revision);
    }

    /** @test */
    public function if_advert_is_deleted_its_name_reflects_that_fact()
    {
        $title = $this->advert->title;

        $this->advert->archive();

        $this->assertEquals($title.' (zakończone)', $this->advert->fresh()->title);
    }
    
    /** @test */
    public function it_can_check_if_there_is_a_phone_number_should_be_visible()
    {
        $this->advert->phone = 500600700;

        $this->advert->user->hide_phone = false;

        $this->assertTrue($this->advert->hasVisiblePhoneNumber());

        $this->advert->user->hide_phone = true;

        $this->assertFalse($this->advert->hasVisiblePhoneNumber());
    }

    /** @test */
    public function it_hides_a_phone_number_from_view()
    {
        $this->advert->phone = 500600700;
        
        $this->assertSame('500 XXX XXX', $this->advert->phone_translated);
    }
    
    /** @test */
    public function it_can_fetch_latitude()
    {
        $this->advert->street->lat = 20.5;
        
        $this->assertSame($this->advert->lat, $this->advert->street->lat);

        $this->advert->street = null;

        $this->advert->city->lat = 30.5;

        $this->assertSame($this->advert->lat, $this->advert->city->lat);
    }
    
    /** @test */
    public function it_can_fetch_longtitude()
    {
        $this->advert->street->lon = 20.5;
        
        $this->assertSame($this->advert->lon, $this->advert->street->lon);

        $this->advert->street = null;

        $this->advert->city->lon = 30.5;

        $this->assertSame($this->advert->lon, $this->advert->city->lon);
    }
}