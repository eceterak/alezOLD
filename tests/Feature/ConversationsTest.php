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
    public function only_participants_of_conversation_can_view_it() 
    {
        $conversation = ConversationFactory::create();

        $this->actingAs($this->user())->get(route('conversations.show', $conversation->id))->assertStatus(403);
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
    public function only_participants_of_a_conversation_can_reply() 
    {
        $advert = AdvertFactory::create();
        
        $john = $this->signIn();
        
        $conversation = $advert->inquiry('Hi mate');
        
        $adam = $this->signIn();
        
        $this->post(route('conversations.reply', $conversation->id), $attributes = [
            'body' => 'I do agree'
        ])->assertStatus(403);
    }

    /** @test */
    public function a_user_can_send_up_to_6_replies_in_a_row_without_answer_before_spam_protection_kicks_in()
    {
        $this->signIn();
        
        $conversation = ConversationFactory::messageCount(6)->create();

        $this->post(route('conversations.reply', $conversation->id), $attributes = [
            'body' => 'I do agree'
        ])->assertSessionHasErrors('messageError');
    }
    
    /** @test */
    public function conversation_can_not_be_continued_if_any_of_participants_deleted_an_account() 
    {
        $advert = AdvertFactory::create();
        
        $john = $this->signIn();
        
        $conversation = $advert->inquiry('Hi mate');

        $john->deleteAccount();
        
        $this->signIn($advert->user);
        
        Notification::fake();

        $this->get(route('conversations.show', $conversation->id))->assertDontSeeText('Odpowiedz')->assertSeeText('Twój rozmówca skasował konto');

        $this->post(route('conversations.reply', $conversation->id), [])->assertRedirect(route('conversations.show', $conversation->id))->assertSessionHasErrors('messageError');

        Notification::assertNotSentTo($john, YouHaveANewMessage::class);
    }

    /** @test */
    public function a_conversation_can_check_if_authenticated_user_has_read_new_messages()
    {
        $this->signIn();
        
        $advert = AdvertFactory::create();
        
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
    public function inquiry_cannot_be_sent_if_advert_was_deleted()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        
        $advert = AdvertFactory::create();

        $advert->archive();
        
        Notification::fake();
        
        $this->post(route('conversations.store', [$advert->city->slug, $advert->slug]))->assertRedirect()->assertSessionHasErrors('self');

        Notification::assertNotSentTo($advert->user, YouHaveANewMessage::class, function($notification, $channels) {
            return (in_array('mail', $channels) && in_array('database', $channels));
        });
    }
    
    /** @test */
    public function inquiry_cannot_be_sent_if_advert_is_not_verified_yet()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        
        $advert = AdvertFactory::create([
            'verified' => false
        ]);
        
        Notification::fake();
        
        $this->post(route('conversations.store', [$advert->city->slug, $advert->slug]))->assertRedirect()->assertSessionHasErrors('self');

        Notification::assertNotSentTo($advert->user, YouHaveANewMessage::class, function($notification, $channels) {
            return (in_array('mail', $channels) && in_array('database', $channels));
        });
    }

    /** @test */
    public function a_user_should_not_be_able_to_start_a_conversation_with_herself()
    {
        $user = $this->signIn();
        
        $advert = AdvertFactory::ownedBy($user)->create();
        
        Notification::fake();
        
        $this->post(route('conversations.store', [$advert->city->slug, $advert->slug]))->assertRedirect()->assertSessionHasErrors('self');

        Notification::assertNotSentTo($advert->user, YouHaveANewMessage::class, function($notification, $channels) {
            return (in_array('mail', $channels) && in_array('database', $channels));
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
    public function a_user_can_view_all_conversations_about_the_advert()
    {
        $conversation = ConversationFactory::create();

        $this->signIn($conversation->advert->user);

        $this->get(route('conversations.advert', $conversation->advert->slug))->assertSee($conversation->messages->first()->body);
    }
}
