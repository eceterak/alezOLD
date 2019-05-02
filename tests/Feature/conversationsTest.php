<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ConversationFactory;
use Facades\Tests\Setup\RoomFactory;
use App\Conversation;

class conversationsTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_only_participant_of_conversation_can_reply() 
    {
        $this->user();

        $conversation = ConversationFactory::create();

        $this->get(route('conversations.show', $conversation->path()))->assertStatus(403);
    }

    // @test
    public function test_a_user_can_start_a_conversation()
    {
        $this->user();

        $room = RoomFactory::create();

        $this->get(route('rooms.show', [$room->city->slug, $room->slug]))->assertSee('Napisz wiadomosc');

        $this->post(route('conversations.store', [$room->city->slug, $room->slug]), $attributes = [
            'body' => 'Hi mate I want this room'
        ])->assertRedirect(route('rooms.show', [$room->city->slug, $room->slug]));

        $this->get(route('conversations.inbox'))->assertSee($attributes['body']);

        // Mail.
    }

    // @test
    public function test_authenticated_user_can_reply() 
    {
        $this->withoutExceptionHandling();

        $user = $this->user();
        
        $conversation = ConversationFactory::sentBy($user)->create();

        $this->get(route('conversations.show', $conversation->path()))->assertSee($conversation->body);
 
        $this->post(route('conversations.reply', $conversation->path()), $attributes = [
            'body' => 'I do agree'
        ])
        ->assertRedirect(route('conversations.show', $conversation->path()));
        
        $this->get(route('conversations.show', $conversation->path()))->assertSee($attributes['body']);
    }
}
