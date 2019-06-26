<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Facades\Tests\Setup\AdvertFactory;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdvertNeedsVerification;
use App\User;
use App\Notifications\AdvertNeedsRevision;

class AdvertsManagementNotificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_notification_for_admin_is_prepared_when_advert_is_created()
    {
        $admin = $this->signInAdmin();

        $secondAdmin = create(User::class, [
            'role' => 1
        ]);

        Notification::fake();

        $advert = AdvertFactory::create();

        Notification::assertSentTo($admin, AdvertNeedsVerification::class);
        Notification::assertSentTo($secondAdmin, AdvertNeedsVerification::class);
    }

    /** @test */
    public function a_notification_for_admin_is_prepared_when_advert_is_updated()
    {
        $admin = $this->signInAdmin();

        Notification::fake();

        $advert = AdvertFactory::create();

        $advert->revise([
            'title' => 'foo'
        ]);

        Notification::assertSentTo($admin, AdvertNeedsRevision::class);
    }

    /** @test */
    public function when_admin_verifies_an_advert_verification_notifications_are_set_as_read()
    {
        $admin = $this->signInAdmin();

        $secondAdmin = create(User::class, [
            'role' => 1
        ]);

        $advert = AdvertFactory::create();

        $notification = DatabaseNotification::where('subject_id', $advert->id)->where('type', 'App\Notifications\AdvertNeedsVerification')->first();

        $advert->verify();

        $this->assertTrue($admin->notifications()->where('subject_id', $advert->id)->where('type', 'App\Notifications\AdvertNeedsVerification')->first()->read());
        $this->assertTrue($secondAdmin->notifications()->where('subject_id', $advert->id)->where('type', 'App\Notifications\AdvertNeedsVerification')->first()->read());
    }

    /** @test */
    public function when_admin_accepts_revision_an_advert_revision_notifications_are_set_as_read()
    {
        $admin = $this->signInAdmin();

        $advert = AdvertFactory::create();

        $advert->revise([
            'title' => 'foo'
        ]);

        $notification = DatabaseNotification::where('subject_id', $advert->id)->where('type', 'App\Notifications\AdvertNeedsRevision')->first();

        $advert->acceptRevision();

        $this->assertTrue($admin->notifications()->where('subject_id', $advert->id)->where('type', 'App\Notifications\AdvertNeedsRevision')->first()->read());
    }

    /** @test */
    public function when_admin_rejects_revision_an_advert_revision_notifications_are_set_as_read()
    {
        $admin = $this->signInAdmin();

        $advert = AdvertFactory::create();

        $advert->revise([
            'title' => 'foo'
        ]);

        $notification = DatabaseNotification::where('subject_id', $advert->id)->where('type', 'App\Notifications\AdvertNeedsRevision')->first();

        $advert->rejectRevision();

        $this->assertTrue($admin->notifications()->where('subject_id', $advert->id)->where('type', 'App\Notifications\AdvertNeedsRevision')->first()->read());
    }

    /** @test */
    public function admin_can_display_all_of_her_unread_notifications()
    {
        $admin = $this->signInAdmin();

        $unread = create(DatabaseNotification::class, [
            'data' => [
                'message' => 'Nowe ogłoszenie w Foo',
                'link' => '123.pl'
            ]
        ]);

        $this->get(route('admin.notifications'))->assertSee($unread->data['message']);
    }

    /** @test */
    public function notifications_marked_as_read_wont_be_displayed()
    {
        $admin = $this->signInAdmin();

        $read = create(DatabaseNotification::class, [
            'data' => [
                'message' => 'Nowe ogłoszenie w Foo',
                'link' => '123.pl'
            ]
        ]);

        $read->markAsRead();

        $this->get(route('admin.notifications'))->assertDontSee($read->data['message']);
    }
}
