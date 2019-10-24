<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\AdvertFactory;
use App\User;
use App\City;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_have_adverts() 
    {
        $advert = AdvertFactory::ownedBy($user = $this->signIn())->create();

        $this->assertInstanceOf(Collection::class, $user->adverts);

        $this->get(route('home'))->assertSee($advert->title);
    }

    /** @test */
    public function user_can_have_conversations() 
    {
        $magda = create(User::class);
        $magdaAdvert = AdvertFactory::ownedBy($magda)->create();

        $marek = $this->signIn();
        $magdaAdvert->inquiry('Hi Magda, nice advert you have');

        $this->assertCount(1, $magda->conversations);
    }

    /** @test */
    public function user_can_be_an_admin()
    {
        $user = create(User::class, ['role' => 1]);

        $this->assertEquals(true, $user->isAdmin());
    }

    /** @test */
    public function a_user_can_fetch_her_most_recent_advert()
    {
        $user = create(User::class);

        $advert = AdvertFactory::ownedBy($user)->create();

        $this->assertEquals($advert->id, $user->lastAdvert->id);
    }

    /** @test */
    public function user_can_determine_her_avatar_path()
    {
        $user = create(User::class);

        $this->assertEquals('/storage/avatars/notfound.jpg', $user->avatar_path);
        
        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals('/storage/avatars/me.jpg', $user->avatar_path);
    }

    /** @test */
    public function a_user_needs_to_confirm_email_address_prior_registration()
    {
        $this->post(route('register'), [
            'name' => 'marek',
            'email' => 'asd@asd.pl',
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ]);

        $user = User::where('name', 'marek')->first();

        $this->assertNull($user->email_verified_at);
    }

    /** @test */
    public function a_user_has_favourite_adverts()
    {
        $user = $this->signIn();
        
        $advert = AdvertFactory::create();

        $advert->favourite();

        $this->assertCount(1, $user->favourites);
    } 

    /** @test */
    public function a_user_has_subscribed_cities()
    {
        $user = $this->signIn();

        $city = create(City::class);

        $city->subscribe();

        $this->assertCount(1, $user->subscriptions);
    }

    /** @test */
    public function a_user_can_specify_if_she_wants_to_receive_email_notifications()
    {
        $user = $this->signIn();

        $this->assertTrue($user->fresh()->acceptsEmailNotifications());
    }

    /** @test */
    public function user_account_can_delete_itself()
    {
        $user = create(User::class);

        $user->deleteAccount();

        $this->assertFalse($user->fresh()->active);
    }

    /** @test */
    public function it_can_delete_avatar()
    {
        $user = $this->signIn();

        Storage::fake('public');

        $oldAvatar = UploadedFile::fake()->image('avatar.jpg');

        $this->json('POST', route('api.users.avatars.store', $user->name), [
            'avatar' => $oldAvatar
        ]);

        $user->deleteAvatar();
        
        Storage::disk('public')->assertMissing("avatars/{$oldAvatar->hashName()}");

        $this->assertEquals('/storage/avatars/notfound.jpg', $user->avatar_path);
    }

    /** @test */
    public function it_can_generate_a_link_to_its_profile()
    {
        $user = create(User::class);

        $user->refresh();

        $this->assertEquals('<a href="'.route('profiles.show', $user->id).'" class="text-dark">'.$user->name.'</a>', $user->path);
    }
}
