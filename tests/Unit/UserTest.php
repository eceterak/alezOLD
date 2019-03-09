<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_adverts() 
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->adverts);
    }
}
