<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ProfilesManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_display_all_profiles()
    {
        $this->signInAdmin();

        $user = create(User::class);

        $this->get(route('admin.profiles'))->assertSee($user->name);
    }
}
