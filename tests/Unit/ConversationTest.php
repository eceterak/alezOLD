<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ConversationFactory;

class ConversationTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_it_has_sender()
    {
        $conversation = ConversationFactory::create();

        $this->assertInstanceOf('App\User', $conversation->sender);
    }

    // @test
    public function test_it_can_reply()
    {
        $this->user();

        $conversation = ConversationFactory::create();
        
        $conversation->reply('Thanks mate');

        $this->assertCount(1, $conversation->messages);
    }
}
