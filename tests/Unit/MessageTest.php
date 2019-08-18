<?php

namespace Tests\Unit;

use Tests\TestCase;
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

        $this->assertEquals($advert->user->name, $receiver->name);
    }

    /** @test */
    public function it_requires_a_body()
    {
        $advert = AdvertFactory::create();

        $this->signIn();

        $this->post(route('conversations.store', [$advert->city->slug, $advert->slug]))->assertSessionHasErrors('body');
    }

    /** @test */
    public function message_must_be_at_least_2_characters_long()
    {
        $advert = AdvertFactory::create();

        $this->signIn();

        $this->post(route('conversations.store', [$advert->city->slug, $advert->slug], [
            'body' => 'h'
        ]))->assertSessionHasErrors('body');
    }
}
