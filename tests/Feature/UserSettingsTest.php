<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_update_his_bio()
    {
        $user = $this->signIn();
        
        $this->post(route('settings.update'), [
            'bio' => 'Just an ordinary boy'
        ])->assertRedirect(route('settings'));

        $this->assertEquals('Just an ordinary boy', $user->bio);

        $this->get(route('profiles.show', $user->id))->assertSee('Just an ordinary boy');
    }
}
