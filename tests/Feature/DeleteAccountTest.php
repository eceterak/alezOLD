<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\City;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\User;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_delete_her_account()
    {
        $user = $this->signIn();

        $this->post(route('account.delete'));

        tap($user->fresh(), function($user) 
        {
            $this->assertFalse($user->fresh()->active);

            $this->assertEquals(now(), $user->fresh()->deleted_at);
        });
    }
    
    /** @test */
    public function when_user_deletes_an_account_all_of_her_adverts_are_archived()
    {
        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        $user->deleteAccount();

        $this->assertTrue($advert->fresh()->archived);
    }
    
    /** @test */
    public function when_user_deletes_an_account_all_of_her_favourites_are_deleted()
    {
        $user = $this->signIn();

        $advert = AdvertFactory::create();
        $advert2 = AdvertFactory::create();

        $favourite = $advert->favourite();
        $advert2->favourite();

        $this->assertDatabaseHas('favourites', $favourite->toArray());

        $user->deleteAccount();

        $this->assertDatabaseMissing('favourites', $favourite->toArray());

        $this->assertCount(0, $user->favourites);
    }

    /** @test */
    public function when_user_deletes_an_account_all_of_her_subscriptions_are_deleted()
    {
        $user = $this->signIn();

        $city = create(City::class);

        $subscription = $city->subscribe();

        $this->assertDatabaseHas('city_subscriptions', $subscription->toArray());

        $user->deleteAccount();

        $this->assertDatabaseMissing('city_subscriptions', $subscription->toArray());
    }

    /** @test */
    public function when_user_deletes_an_account_all_of_her_notifications_are_deleted()
    {
        $user = $this->signIn();

        $notification = create(DatabaseNotification::class);

        $this->assertDatabaseHas('notifications', $notification->only('id'));

        $user->deleteAccount();

        $this->assertDatabaseMissing('notifications', $notification->only('id'));
    }

    /** @test */
    public function when_user_deletes_an_account_all_of_her_activities_are_deleted()
    {
        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        $this->assertDatabaseHas('activities', $user->activities->first()->only('id'));

        $user->deleteAccount();

        $this->assertDatabaseMissing('activities', $user->activities->first()->only('id'));
    }

    /** @test */
    public function when_user_deletes_an_account_avatar_is_deleted_as_well()
    {
        $user = $this->signIn();

        Storage::fake('public');

        $oldAvatar = UploadedFile::fake()->image('avatar.jpg');

        $this->json('POST', route('api.users.avatars.store', $user->name), [
            'avatar' => $oldAvatar
        ]);

        $user->deleteAccount();

        Storage::disk('public')->assertMissing("avatars/{$oldAvatar->hashName()}");

        $this->assertEquals('/storage/avatars/notfound.jpg', $user->avatar_path);
    }

    /** @test */
    public function deleted_user_can_not_login() 
    {
        $this->withoutExceptionHandling(); // Do not remove.

        $this->get(route('login'))->assertSuccessful();

        $user = create(User::class, [
            'password' => bcrypt($password = 'test123')
        ]);

        $user->deleteAccount();

        $this->expectException('Illuminate\Validation\ValidationException');

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password
        ]);
    }

    /** @test */
    public function when_trying_to_access_the_path_to_the_users_account_it_returns_deleted_account_string()
    {
        $user = create(User::class);

        $advert = AdvertFactory::ownedBy($user)->create();

        $user->deleteAccount();

        $this->assertEquals('<span class="text-muted">konto usunięte</span>', $user->fresh()->path);

        $this->get(route('adverts.show', [$advert->city->slug, $advert->slug]))->assertSeeText('konto usunięte');
    }
}
