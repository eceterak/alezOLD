<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Facades\Tests\Setup\AdvertFactory;
use App\Notifications\YouHaveANewMessage;

class UserSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_add_a_phone_number()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $this->post(route('settings.update'), [
            'phone' => 650650650
        ])->assertRedirect(route('settings'));

        $this->assertEquals(650650650, $user->phone);
    }

    /** @test */
    public function provided_phone_number_must_be_between_9_and_13_characters()
    {
        $user = $this->signIn();

        $this->post(route('settings.update'), [
            'phone' => 650
        ])->assertSessionHasErrors('phone');

        $this->post(route('settings.update'), [
            'phone' => 650650650650650
        ])->assertSessionHasErrors('phone');
    }

    /** @test */
    public function a_user_can_hide_her_phone_number()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $this->assertFalse($user->hide_phone);

        $this->post(route('settings.update'), [
            'hide_phone' => 1
        ]);

        $this->assertTrue($user->fresh()->hide_phone);
    }

    /** @test */
    public function a_user_can_update_her_bio()
    {
        $user = $this->signIn();
        
        $this->post(route('settings.update'), [
            'bio' => 'Just an ordinary boy'
        ])->assertRedirect(route('settings'));

        $this->assertEquals('Just an ordinary boy', $user->bio);

        $this->get(route('profiles.show', $user->id))->assertSee('Just an ordinary boy');
    }

    /** @test */
    public function a_user_can_disable_email_notifications()
    {
        $user = $this->signIn();

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
}
