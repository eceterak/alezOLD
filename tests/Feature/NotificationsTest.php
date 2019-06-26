<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Facades\Tests\Setup\AdvertFactory;
use App\Notifications\AdvertWasAdded;
use App\Conversation;
use App\Advert;
use App\City;
use App\User;
use App\Notifications\AdvertNeedsVerification;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_city_receives_a_new_verified_advert()
    {
        $city = create(City::class);

        $city->subscribe();
        
        tap(auth()->user(), function($user) use ($city) {

            Notification::fake();

            $advert = AdvertFactory::city($city)->create();

            $advert->verify();

            Notification::assertSentTo($user, AdvertWasAdded::class);
        });
    }

    /** @test */
    public function when_subscribed_city_receives_a_new_advert_notification_wont_be_sent_to_owner_of_the_advert()
    {
        $city = create(City::class);

        $city->subscribe();
        
        tap(auth()->user(), function($user) use ($city) {
            
            Notification::fake();

            $advert = AdvertFactory::city($city)->ownedBy(auth()->user())->create();

            $advert->verify();
            
            Notification::assertNotSentTo($user, AdvertWasAdded::class);
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

        $notification = create(DatabaseNotification::class, [
            'data' => ['message' => 'Nowe ogłoszenie w Foo']
        ]);
        
        $this->get(route('subscriptions'))->assertSee('Nowe ogłoszenie w Foo');
    }
}