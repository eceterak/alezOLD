<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Facades\Tests\Setup\AdvertFactory;
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
        $city = create(City::class)->subscribe();
        
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
}
