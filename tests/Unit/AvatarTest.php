<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class AvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
        $user = $this->signIn();

        $response = $this->json('POST', route('api.users.avatars.store', $user->name), [
            'avatar' => 'Not an image'
        ])->assertStatus(422);
    }

    /** @test */
    public function avatar_can_not_be_over_400_kb()
    {
        $user = $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg')->size(401);

        $response = $this->json('POST', route('api.users.avatars.store', $user->name), [
            'avatar' => $file
        ])->assertJsonValidationErrors('avatar');
    }
}
