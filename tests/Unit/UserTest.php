<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\RoomFactory;
use App\Conversation;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_user_can_login() 
    {
        $this->get(route('login'))->assertSuccessful();

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'test123')
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => $password
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    // @test
    public function test_user_has_rooms() 
    {
        $user = $this->user();

        $room = RoomFactory::ownedBy($user)->create();

        $this->assertInstanceOf(Collection::class, $user->rooms);

        $this->get(route('home'))->assertSee($room->title);
    }

    // @test
    public function test_user_has_conversations() 
    {
        $magda = factory(User::class)->create();
        $magdaRoom = RoomFactory::ownedBy($magda)->create();

        $marek = $this->user();
        $magdaRoom->inquiry('Hi Magda, nice room you have');

        $this->assertCount(1, $marek->conversations());
        $this->assertCount(1, $magda->conversations());    
           
        $wiesiek = $this->user();

        $this->user($wiesiek);
        $magdaRoom->inquiry('Hi Magda, nice room you have');
        
        $this->assertCount(2, $magda->conversations());    
        $this->assertCount(1, $marek->conversations());
        $this->assertCount(1, $wiesiek->conversations());
    }

    // @test
    public function test_user_can_be_an_admin()
    {
        $user = factory(User::class)->create(['role' => 1]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'role' => $user->role
        ]);

        $this->assertEquals(true, $user->isAdmin());
    }

    // @test
    public function test_admin_can_access_the_backend() 
    {
        $user = factory(User::class)->create(['role' => 1]);

        $this->actingAs($user)->get(route('admin'))->assertStatus(200);
    }

    // @test
    public function test_guest_cant_enter_the_backend() 
    {
        $this->get(route('admin'))->assertRedirect(route('admin.login'));

        $this->user();

        $this->get(route('admin'))->assertRedirect(route('index'));
    }
}
