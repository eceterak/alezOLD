<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\User;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_determine_for_whom_is_sent_for()
    {
        $advert = AdvertFactory::create();

        $this->signIn();

        $conversation = $advert->inquiry('hi');

        $this->assertInstanceOf(User::class, $receiver = $conversation->messages->first()->receiver);

        $this->assertEquals(1, $receiver->id);
    }
}
