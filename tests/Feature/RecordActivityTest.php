<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\Activity;
use App\City;

class RecordActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_an_advert_records_an_activity()
    {
        $this->signIn();

        $advert = AdvertFactory::create();

        $this->assertDatabaseHas('activities', [
            'user_id' => auth()->user()->id,
            'description' => 'created_advert',
            'subject_id' => $advert->id,
            'subject_type' => 'App\Advert'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $advert->id);

        $this->assertCount(1, $advert->activities);
    }

    /** @test */
    public function updating_an_advert_records_an_activity()
    {
        $advert = AdvertFactory::create();

        $this->actingAs($advert->user)->patch(route('adverts.update', [$advert->city->slug, $advert->slug]), [
            'city_id' => $advert->city->id,
            'street_id' => $advert->street->id,
            'title' => 'some dummy title',
            'room_size' => $advert->room_size,
            'description' => 'description has been updated',
            'rent' => 2000,
            'pets' => 1
        ])->assertRedirect(route('home'));

        $this->assertCount(2, $advert->activities);
        $this->assertEquals('updated_advert', $advert->activities->last()->description);
    }

    /** @test */
    public function verifying_an_advert_records_an_activity()
    {
        $advert = AdvertFactory::create([
            'verified' => false
        ]);

        $advert->verify();

        $this->assertCount(2, $advert->activities);
        $this->assertEquals('verified_advert', $advert->activities->last()->description);
    }

    /** @test */
    public function deleting_an_advert_records_an_activity()
    {
        $advert = AdvertFactory::create();

        $advert->archive();

        $this->assertCount(2, $advert->activities);
        $this->assertEquals('deleted_advert', $advert->activities->last()->description);
    }

    /** @test */
    public function deleting_a_city_deletes_all_activities_assorted_with_adverts_within()
    {        
        $this->signInAdmin();

        $city = create(City::class);

        $advert = AdvertFactory::city($city)->create();

        $this->delete(route('admin.cities.destroy', $city->slug));;

        $this->assertDatabaseMissing('activities', [
            'subject_id' => $advert->id,
            'subject_type' => get_class($advert)
        ]);
    }
}
