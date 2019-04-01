<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User can login.
     * 
     * @return void
     */
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

    /**
     * A user can have multiple rooms.
     * 
     * @return test
     */
    public function test_user_has_rooms() 
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->rooms);
    }

    /**
     * A simple test to check if user has admin privileges.
     * 
     * @return test
     */
    public function test_user_can_be_an_admin()
    {
        $user = factory(User::class)->create(['role' => 1]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'role' => $user->role
        ]);

        $this->assertEquals(true, $user->isAdmin());
    }

    /**
     * Check if user with admin privileges can access the backend area.
     * 
     * @return test
     */
    public function test_admin_can_access_the_backend() 
    {
        $user = factory(User::class)->create(['role' => 1]);

        $this->actingAs($user)->get('/admin')->assertStatus(200);
    }

    /**
     * Ensure that non admins can't enter the backend area.
     * 
     * @return test
     */
    public function test_guest_cant_enter_the_backend() 
    {
        $this->get(route('admin'))->assertRedirect(route('admin.login'));

        $this->user();

        $this->get(route('admin'))->assertRedirect(route('index'));
    }
}
