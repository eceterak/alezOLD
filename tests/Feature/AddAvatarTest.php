<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_members_can_add_avatars()
    {
        $response = $this->json('POST', route('api.users.avatars.store', 'john'))->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
        $user = $this->signIn();

        $response = $this->json('POST', route('api.users.avatars.store', $user->name), [
            'avatar' => 'Not an image'
        ])->assertStatus(422);
    }

    /** @test */
    public function a_user_may_add_an_avatar_to_their_profile()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->json('POST', route('api.users.avatars.store', $user->name), [
            'avatar' => $file
        ]);

        $this->assertEquals("/storage/avatars/{$file->hashName()}", auth()->user()->avatar_path);
        
        Storage::disk('public')->assertExists("avatars/{$file->hashName()}");
    }
}
