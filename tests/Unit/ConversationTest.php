<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ConversationFactory;

class ConversationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_sender()
    {
        $conversation = ConversationFactory::create();

        $this->assertInstanceOf('App\User', $conversation->sender);
    }

    /** @test */
    public function it_can_reply()
    {
        $this->signIn();

        $conversation = ConversationFactory::create();
        
        $conversation->reply('Thanks mate');

        $this->assertCount(1, $conversation->messages);
    }

    /** @test */
    public function it_requires_a_body()
    {
        $conversation = ConversationFactory::create();

        $this->actingAs($conversation->sender)->post(route('conversations.reply', $conversation->id), [
            'body' => null
        ])
        ->assertSessionHasErrors('body');
    }
}
