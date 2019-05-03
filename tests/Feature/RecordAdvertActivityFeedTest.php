<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\RoomFactory;

class RecordAdvertActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_creating_an_advert()
    {
        $advert = RoomFactory::create();
        
        $this->assertCount(1, $advert->activities);
        
        tap($advert->activities->last(), function($activity)
        {
            $this->assertEquals('created_room', $activity->description);

            $this->assertNull($activity->changes);
        });

    }

    // @test
    public function test_updating_an_advert()
    {
        $advert = RoomFactory::create();

        $title = $advert->title;

        $advert->update([
            'title' => 'updated'
        ]);

        $this->assertCount(2, $advert->activities);
        
        tap($advert->activities->last(), function($activity) use ($title)
        {
            $this->assertEquals('updated_room', $activity->description);

            $expected = [
                'before' => ['title' => $title],
                'after' => ['title' => 'updated']
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    // @test
    public function test_verifying_an_advert()
    {
        $advert = RoomFactory::create();

        $advert->verify();

        $this->assertCount(3, $advert->activities);
        $this->assertEquals('verified_room', $advert->activities->last()->description);
    }
}
