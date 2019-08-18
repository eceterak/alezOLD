<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use Facades\Tests\Setup\ConversationFactory;

class FeaturesThrottlingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_start_10_conversations_per_minute()
    {
        $this->signIn();
        
        $advert = AdvertFactory::create();
                
        for($i = 0; $i <= 9; $i++) $this->post(route('conversations.store', [$advert->city->slug, $advert->slug]), ['body' => 'Hi mate I want this room'])->assertStatus(302);

        $this->post(route('conversations.store', [$advert->city->slug, $advert->slug]), ['body' => 'Hi mate I want this room'])->assertStatus(429);
    }

    /** @test */
    public function user_can_send_only_15_messages_per_minute() 
    {
        $conversation = ConversationFactory::create();
        
        $this->signIn($conversation->sender);

        for($i = 0; $i <= 14; $i++) $this->post(route('conversations.reply', $conversation->id), ['body' => 'I do agree'])->assertStatus(302);

        $this->post(route('conversations.reply', $conversation->id), ['body' => 'spamming'])->assertStatus(429);
    }
}
