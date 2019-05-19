<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\Activity;
use Carbon\Carbon;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $advert = AdvertFactory::create();

        $this->assertEquals(auth()->user()->id, $advert->activities->first()->user->id);
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();
        
        AdvertFactory::create();

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
    }
}
