<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Facades\Tests\Setup\AdvertFactory;
use App\Notifications\YouHaveANewMessage;
use App\Conversation;
use App\Advert;
use App\City;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_city_receives_a_new_advert_that_is_not_by_current_user()
    {
        $city = create(City::class);

        $city->subscribe();
        
        tap(auth()->user(), function($user) use ($city) {

            AdvertFactory::city($city)->ownedBy(auth()->user())->create();
            
            $this->assertCount(0, $user->notifications);

            AdvertFactory::city($city)->create();

            $this->assertCount(1, $user->fresh()->notifications);
        });
    }

    /** @test */
    public function a_user_can_fetch_unread_notifications()
    {
        create(DatabaseNotification::class);
        
        $response = $this->getJson(route('profiles.notifications', auth()->user()->name))->json();
        
        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        tap(auth()->user(), function($user) {
            $this->assertCount(1, $user->unreadNotifications);
    
            $notification = $user->unreadNotifications->first();
    
            $this->delete(route('profiles.notifications.delete', [$user->name, $notification->id]));
    
            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    } 

    /** @test */
    public function a_user_can_disable_email_notifications()
    {
        $user = auth()->user();

        Notification::fake();
        
        $this->post(route('settings.update'), [])->assertRedirect(route('settings'));

        $this->assertFalse($user->acceptsEmailNotifications());
        
        $advert = AdvertFactory::ownedBy($user)->create();
        
        $this->signIn();

        $advert->inquiry('Email notification should not be sent.');

        Notification::assertSentTo($user, YouHaveANewMessage::class, function($notification, $channels) {
            return (!in_array('mail', $channels) && in_array('database', $channels));
        });
    }

    /** @test */
    public function a_user_can_fetch_unread_notifications_of_a_given_type()
    {
        create(DatabaseNotification::class);
        create(DatabaseNotification::class);

        $this->assertEquals(2, auth()->user()->hasUnreadNotificationsOfType('AdvertWasAdded'));
    }

    /** @test */
    public function notification_is_marked_as_read_when_user_visits_its_subject()
    {
        $firstNotification = create(DatabaseNotification::class);

        $secondNotification = factory(DatabaseNotification::class)->state('conversation')->create();

        tap(auth()->user(), function($user) use ($firstNotification, $secondNotification) {
            $this->assertCount(2, $user->unreadNotifications);
            
            $advert = Advert::find($firstNotification->subject_id);
            
            $this->get(route('adverts.show', [$advert->city->slug, $advert->slug]));
            
            $conversation = Conversation::find($secondNotification->subject_id);

            $this->get(route('conversations.show', $conversation->id));
        
            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }

    /** @test */
    public function a_user_can_view_all_of_her_notifications_of_a_given_type()
    {
        $this->withoutExceptionHandling(); // Do not remove - false positive.

        create(DatabaseNotification::class, [
            'data' => ['message' => 'Nowe ogłoszenie w Foo']
        ]);
        
        $this->get(route('subscriptions'))->assertSee('Nowe ogłoszenie w Foo');
    }
}
