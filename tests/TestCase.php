<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Act as an regular user.
     * @param $user [User/null]
     * 
     * @return App\User
     */
    protected function user($user = null) 
    {
        $user = $user ?: factory('App\User')->create(['role' => 1]);

        $this->actingAs($user);

        return $user;
    }

    /**
     * Act as an admin.
     * @param $user [User/null]
     * 
     * @return App\User
     */
    protected function admin($admin = null) 
    {
        $admin = $admin ?: factory('App\User')->create(['role' => 1]);

        $this->actingAs($admin);

        return $admin;
    }
}
