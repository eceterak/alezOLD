<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Facades\Tests\Setup\ConversationFactory;
use App\Notifications\YouHaveANewMessage;
use Facades\Tests\Setup\AdvertFactory;
use Illuminate\Support\Facades\Mail;

class ConversationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_start_a_conversation()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $this->signIn();
        
        $advert = AdvertFactory::create();
        
        Notification::fake();

        $this->get(route('adverts.show', [$advert->city->slug, $advert->slug]))->assertSee('Napisz wiadomosc');
        
        $this->post(route('conversations.store', [$advert->city->slug, $advert->slug]), $attributes = [
            'body' => 'Hi mate I want this advert'
        ])->assertRedirect(route('adverts.show', [$advert->city->slug, $advert->slug]));

        // We can see new conversation in the sent folder @todo sent folder is not yet working
        //$this->get(route('conversations.inbox'))->assertSee($attributes['body']);

        Notification::assertSentTo($advert->user, YouHaveANewMessage::class);
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

    /** @test */
    public function a_conversation_can_check_if_authenticated_user_has_read_new_messages()
    {
        $advert = AdvertFactory::create();

        $this->signIn();
        
        $conversation = $advert->inquiry('Just testing');

        $this->signIn($advert->user);

        tap(auth()->user(), function($user) use ($conversation) 
        {
            $this->assertTrue($conversation->hasNewMessagesFor($user));
    
            $user->read($conversation);
    
            $this->assertFalse($conversation->hasNewMessagesFor($user));
        });
    }
}
