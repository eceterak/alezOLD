<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_change_her_password()
    {
        $user = $this->signIn();

        $this->get(route('password.change'))->assertSee('Zmień hasło');

        $this->post(route('password.change.store', [
            'password' => 'asd123',
            'password_confirmation' => 'asd123'
        ]))->assertRedirect(route('home'))
            ->assertSessionHas('flash', 'Hasło zostało zmienione');

        $this->assertTrue(Hash::check('asd123', $user->fresh()->password));
    }
}
