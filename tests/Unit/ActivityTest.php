<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        $this->assertEquals(auth()->user()->id, $advert->activities->first()->user->id);
    }
}
