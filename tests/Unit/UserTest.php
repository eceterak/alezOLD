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
    public function can_login() 
    {
        $this->get(route('login'))->assertSuccessful();

        $user = create(User::class, [
            'password' => bcrypt($password = 'test123')
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password
        ])
        ->assertRedirect(route('index'));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function has_adverts() 
    {
        $advert = AdvertFactory::ownedBy($user = $this->signIn())->create();

        $this->assertInstanceOf(Collection::class, $user->adverts);

        $this->get(route('home'))->assertSee($advert->title);
    }

    /** @test */
    public function has_conversations() 
    {
        $magda = create(User::class);
        $magdaAdvert = AdvertFactory::ownedBy($magda)->create();

        $marek = $this->signIn();
        $magdaAdvert->inquiry('Hi Magda, nice advert you have');

        $this->assertCount(1, $marek->conversations());
        $this->assertCount(1, $magda->conversations());    
           
        $wiesiek = $this->signIn();

        $this->user($wiesiek);
        $magdaAdvert->inquiry('Hi Magda, nice advert you have');
        
        $this->assertCount(2, $magda->conversations());    
        $this->assertCount(1, $marek->conversations());
        $this->assertCount(1, $wiesiek->conversations());
    }

    /** @test */
    public function can_be_an_admin()
    {
        $user = create(User::class, ['role' => 1]);

        $this->assertEquals(true, $user->isAdmin());
    }
}
