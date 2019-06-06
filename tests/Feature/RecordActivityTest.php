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

        $title = $advert->title;

        $advert->update([
            'title' => 'updated'
        ]);

        $this->assertCount(2, $advert->activities);
        
        tap($advert->activities->last(), function($activity) use ($title)
        {
            $this->assertEquals('updated_advert', $activity->description);

            $expected = [
                'before' => [
                    'title' => $title,
                    'slug' => str_slug($title)
                ],
                'after' => [
                    'title' => 'updated',
                    'slug' => 'updated'
                ]
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test */
    public function verifying_an_advert_records_an_activity()
    {
        $advert = AdvertFactory::create([
            'verified' => false
        ]);

        $advert->verify();

        $this->assertCount(2, $advert->activities);
    }

    /** @test */
    public function deleting_an_advert_records_an_activity()
    {
        $advert = AdvertFactory::create();

        $advert->archive();

        $this->assertCount(2, $advert->activities);
        //$this->assertEquals('deleted_advert', $advert->activities->last()->description);
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
