<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registered_user_can_login() 
    {
        $this->get(route('login'))->assertSuccessful();

        $user = create(User::class, [
            'password' => bcrypt($password = 'test123')
        ]);

        $this->post(route('login'), [
            'login_email' => $user->email,
            'login_password' => $password
        ])->assertRedirect(route('login'));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_can_register_a_new_account() 
    {
        $this->post(route('register'), [
            'name' => 'john',
            'email' => 'john@gmail.com',
            'password' => 'jd1234',
            'password_confirmation' => 'jd1234'
        ])->assertRedirect(route('verification.notice'));

        $user = User::first();

        $this->assertEquals('john', $user->name);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function unsuccessful_login_attempt_always_redirects_to_a_login_page() 
    {
        $this->post(route('login'), [
            'login_email' => 'email@email.com',
            'login_password' => 'password123'
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function unsuccessful_register_attempt_always_redirects_to_a_register_page() 
    {
        $this->post(route('register'), [
            'name' => 'john',
            'email' => 'john',
            'password' => 'jd1234',
            'password_confirmation' => 'jd1234'
        ])->assertRedirect(route('login'));
    }
}
