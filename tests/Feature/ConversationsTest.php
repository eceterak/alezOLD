<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ConversationFactory;
use Facades\Tests\Setup\AdvertFactory;

class ConversationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_start_a_conversation()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $advert = AdvertFactory::create();

        $this->get(route('adverts.show', [$advert->city->slug, $advert->slug]))->assertSee('Napisz wiadomosc');
        
        $this->post(route('conversations.store', [$advert->city->slug, $advert->slug]), $attributes = [
            'body' => 'Hi mate I want this advert'
        ])
        ->assertRedirect(route('adverts.show', [$advert->city->slug, $advert->slug]));

        $this->get(route('conversations.inbox'))->assertSee($attributes['body']);

        // Mail.
    }

    /** @test */
    public function participant_can_reply() 
    {
        $conversation = ConversationFactory::create();
        
        $this->signIn($conversation->receiver); // Acting as someone who received a message.
        
        $this->get(route('conversations.show', $conversation->id))->assertSee($conversation->body);
    
        $this->post(route('conversations.reply', $conversation->id), $attributes = [
            'body' => 'I do agree'
        ])
        ->assertRedirect(route('conversations.show', $conversation->id));
        
        $this->get(route('conversations.show', $conversation->id))->assertSee($attributes['body']);
    }

    /** @test */
    public function only_participant_of_conversation_can_view_it() 
    {
        $conversation = ConversationFactory::create();

        $this->actingAs($this->user())->get(route('conversations.show', $conversation->id))->assertStatus(403);
    }
}
