<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;

class RecordAdvertActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_an_advert()
    {
        $advert = AdvertFactory::create();
        
        $this->assertCount(1, $advert->activities);
        
        tap($advert->activities->last(), function($activity)
        {
            $this->assertEquals('created_advert', $activity->description);

            $this->assertNull($activity->changes);
        });

    }

    /** @test */
    public function updating_an_advert()
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
                'before' => ['title' => $title],
                'after' => ['title' => 'updated']
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test */
    public function verifying_an_advert()
    {
        $advert = AdvertFactory::create();

        $advert->verify();

        $this->assertCount(3, $advert->activities);
        $this->assertEquals('verified_advert', $advert->activities->last()->description);
    }
}
