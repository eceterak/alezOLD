<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use App\Advert;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function notification_has_a_subject() 
    {
        $notification = create(DatabaseNotification::class);

        $advert = Advert::find($notification->subject_id);

        $this->assertEquals('App\Advert', $notification->subject_type);

        $this->assertSame($advert->id, $notification->subject_id);
    }

    /** @test */
    public function it_can_mark_itself_as_read()
    {
        $user = $this->signIn();
        
        $notification = create(DatabaseNotification::class);

        $advert = Advert::find($notification->subject_id);

        $user->sawNotificationsFor($advert);

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }

    /** @test */
    public function a_user_can_check_how_many_unread_notifications_she_has()
    {
        $user = $this->signIn();

        create(DatabaseNotification::class);
    
        $this->assertEquals(1, $user->notifications_count);
    }

    /** @test */
    public function notifications_count_must_not_exceed_99()
    {
        $user = $this->signIn();

        $user->notifications_count = 121;
        
        $this->assertSame("99+", $user->notifications_count);
    }  
}