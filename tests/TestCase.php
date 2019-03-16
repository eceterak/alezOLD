<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Creates and authenticate a user.
     * @param $user [User/null]
     * @param $adminPrivileges [bool]
     * 
     * @return auth()
     */
    protected function authenticated($user = null, $adminPrivileges = false) 
    {
        return ($adminPrivileges == true) ? $this->actingAs($user ?: factory('App\User')->create(['role' => 1])) : $this->actingAs($user ?: factory('App\User')->create());
    
    }
}
