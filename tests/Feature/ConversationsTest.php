<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\YouHaveANewMessage;
use Facades\Tests\Setup\AdvertFactory;
use Facades\Tests\Setup\ConversationFactory;
use App\User;

class ConversationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_start_a_conversation()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        
        $advert = AdvertFactory::create();
        
        Notification::fake();

        $this->get(route('adverts.show', [$advert->city->slug, $advert->slug]))->assertSee('Napisz wiadomość');
        
        $this->post(route('conversations.store', [$advert->city->slug, $advert->slug]), $attributes = [
            'body' => 'Hi mate I want this room'
        ])->assertRedirect(route('adverts.show', [$advert->city->slug, $advert->slug]));

        $this->assertCount(1, $advert->conversations);

        Notification::assertSentTo($advert->user, YouHaveANewMessage::class, function($notification, $channels) {
            return (in_array('mail', $channels) && in_array('database', $channels));
        });
    }

    /** @test */
    public function participant_of_conversation_can_reply() 
    {
        $advert = AdvertFactory::create();
        
        $john = $this->signIn();
        
        $conversation = $advert->inquiry('Hi mate');
        
        $this->signIn($advert->user);
        
        Notification::fake();

        $this->get(route('conversations.show', $conversation->id))->assertSee($conversation->body);

        $this->post(route('conversations.reply', $conversation->id), $attributes = [
            'body' => 'I do agree'
        ])->assertRedirect(route('conversations.show', $conversation->id));

        $this->get(route('conversations.show', $conversation->id))->assertSee($attributes['body']);

        Notification::assertSentTo($john, YouHaveANewMessage::class);
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
        
    /** @test */
    public function a_user_can_participate_in_many_conversations()
    {
        $magda = create(User::class);
        $magdaAdvert = AdvertFactory::ownedBy($magda)->create();

        $this->signIn();
        $magdaAdvert->inquiry('Hi Magda, nice advert you have');

        $this->assertCount(1, $magda->conversations);
           
        $this->signIn();
        $magdaAdvert->inquiry('Hi Magda, nice advert you have');
        
        $this->assertCount(2, $magda->fresh()->conversations);
    }

    /** @test */
    public function a_user_has_inbox()
    {
        $conversation = ConversationFactory::create();

        $this->actingAs($conversation->advert->user)->get(route('conversations.inbox'))->assertSee($conversation->messages->first()->body);
    }

    /** @test */
    public function a_user_has_sent_folder()
    {
        $conversation = ConversationFactory::create();

        $this->actingAs($conversation->sender)->get(route('conversations.sent'))->assertSee($conversation->messages->first()->body);
    }

    /** @test */
    public function a_user_can_read_all_conversations_about_the_advert()
    {
        $this->withoutExceptionHandling();

        $conversation = ConversationFactory::create();

        $this->signIn($conversation->advert->user);

        $this->get(route('conversations.advert', $conversation->advert->slug))->assertSee($conversation->messages->first()->body);
    }

    /** @test */
    public function a_user_should_not_be_able_to_start_a_conversation_with_herself()
    {
        $user = $this->signIn();
        
        $advert = AdvertFactory::ownedBy($user)->create();
        
        $response = $this->post(route('conversations.store', [$advert->city->slug, $advert->slug]))->assertRedirect()->assertSessionHasErrors();
    }
}
