<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ConversationFactory;
use Facades\Tests\Setup\RoomFactory;
use App\User;

class ConversationsTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_a_user_can_start_a_conversation()
    {
        $this->user();

        $room = RoomFactory::create();

        $this->get(route('rooms.show', [$room->city->slug, $room->slug]))->assertSee('Napisz wiadomosc');
        
        $this->post(route('conversations.store', [$room->city->slug, $room->slug]), $attributes = [
            'body' => 'Hi mate I want this room'
        ])
        ->assertRedirect(route('rooms.show', [$room->city->slug, $room->slug]));

        $this->get(route('conversations.inbox'))->assertSee($attributes['body']);

        // Mail.
    }

    // @test
    public function test_participant_can_reply() 
    {
        $conversation = ConversationFactory::create();
        
        $this->user($conversation->receiver); // Acting as someone who received a message.
        
        $this->get(route('conversations.show', $conversation->id))->assertSee($conversation->body);
    
        $this->post(route('conversations.reply', $conversation->id), $attributes = [
            'body' => 'I do agree'
        ])
        ->assertRedirect(route('conversations.show', $conversation->id));
        
        $this->get(route('conversations.show', $conversation->id))->assertSee($attributes['body']);
    }

    // @test
    public function test_only_participant_of_conversation_can_view_it() 
    {
        $this->user();

        $conversation = ConversationFactory::create();

        $this->get(route('conversations.show', $conversation->id))->assertStatus(403);
    }
}
