<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ConversationFactory;
use Facades\Tests\Setup\AdvertFactory;
use App\Exceptions\MessageException;

class ConversationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_exactly_two_participants()
    {
        $conversation = ConversationFactory::create();

        $this->assertCount(2, $conversation->users);
    }

    /** @test */
    public function it_can_reply()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $conversation = ConversationFactory::create();
        
        $conversation->reply('Thanks mate');

        $this->assertCount(2, $conversation->messages);
    }

    /** @test */
    public function it_requires_a_body()
    {
        $conversation = ConversationFactory::create();

        $this->actingAs($conversation->users[0])->post(route('conversations.reply', $conversation->id), [
            'body' => null
        ])->assertSessionHasErrors('body');
    }

    /** @test */
    public function it_can_define_who_sent_inquiry()
    {
        $advert = AdvertFactory::create();

        $user = $this->signIn();

        $conversation = $advert->inquiry('Hi bruh');

        $this->assertSame($user->id, $conversation->sender->id);
    }

    /** @test */
    public function it_can_check_if_any_of_the_users_did_not_deleted_an_account()
    {
        $advert = AdvertFactory::create();

        $user = $this->signIn();

        $conversation = $advert->inquiry('Hi bruh');
        
        $user->deleteAccount();
        
        $this->expectException(MessageException::class);
        $conversation->areUsersActive();
    }

    /** @test */
    public function it_can_check_if_user_has_not_trying_to_send_too_many_messages_without_a_reply()
    {
        $user = $this->signIn();

        $conversation = ConversationFactory::messageCount(6)->create();

        $this->expectException(MessageException::class);

        $conversation->messagingTooFrequently();
    }

    /** @test */
    public function it_can_recognize_who_interlocutor_is()
    {
        $advert = AdvertFactory::create();

        $user = $this->signIn();

        $conversation = $advert->inquiry('Hi bruh');

        $this->assertSame($advert->user->id, $conversation->interlocutor->id);
    }

    /** @test */
    public function it_has_messages()
    {
        $advert = AdvertFactory::create();

        $user = $this->signIn();

        $conversation = $advert->inquiry('Hi bruh');

        $this->assertCount(1, $conversation->messages);
    }
}
