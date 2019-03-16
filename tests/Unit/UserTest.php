<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user can have multiple adverts.
     * 
     * @return test
     */
    public function test_user_has_adverts() 
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->adverts);
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

        $this->authenticated($user);

        $this->get('/admin')->assertSee('Hi Admin');
    }

    /**
     * Ensure that guest and casual user cannot enter the backend area.
     * 
     * @return test
     */
    public function test_guest_cannot_enter_the_backend() 
    {
        //$this->withExceptionHandling();

        $this->get('/admin')->assertRedirect('/admin/login');

        $this->authenticated();

        $this->get('/admin')->assertRedirect('/');
    }
}
