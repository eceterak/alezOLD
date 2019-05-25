<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\AdvertFactory;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login() 
    {
        $this->get(route('login'))->assertSuccessful();

        $user = create(User::class, [
            'password' => bcrypt($password = 'test123')
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password
        ])->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

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

        $this->assertEquals('/storage/avatars/notfound.png', $user->avatar_path);
        
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
    public function a_user_can_view_her_settings()
    {
        $this->signIn();

        $this->get(route('settings'))->assertSee('Zmień hasło');
    }

    // /** @test */
    // public function a_user_can_change_her_password()
    // {
    //     $user = $this->signIn();        
    // }
}
