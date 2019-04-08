<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\RoomFactory;
use App\Conversation;
use Facades\Tests\Setup\ConversationFactory;

class conversationsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * 
     * 
     * @return void
     */
    public function test_only_participant_of_conversation_can_reply() 
    {
        $this->user();

        $conversation = ConversationFactory::create();

        $this->get(route('conversations.show', $conversation->path()))->assertStatus(403);
    }

    /**
     * A user can start a conversation.
     *
     * @return void
     */
    public function test_a_user_can_start_a_conversation()
    {
        $this->user();

        $room = RoomFactory::create();

        $this->get(route('rooms.show', [$room->city->path(), $room->path()]))->assertSee('Napisz wiadomosc');

        $this->post(route('conversations.store', [$room->city->path(), $room->path()]), $attributes = [
            'body' => 'Hi mate I want this room'
        ])->assertRedirect(route('rooms.show', [$room->city->path(), $room->path()]));

        $this->get(route('conversations.inbox'))->assertSee($attributes['body']);

        // Mail.
    }

    /**
     * A user can reply.
     * 
     * @return void
     */
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
