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
        $user = $this->signIn();

        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->json('POST', route('api.users.avatars.store', $user->name), [
            'avatar' => $file
        ]);

        $this->assertEquals("/storage/avatars/{$file->hashName()}", auth()->user()->avatar_path);
        
        Storage::disk('public')->assertExists("avatars/{$file->hashName()}");
    }

    /** @test */
    public function when_user_uploads_new_avatar_old_one_is_deleted()
    {
        $user = $this->signIn();

        Storage::fake('public');

        $oldAvatar = UploadedFile::fake()->image('avatar.jpg');

        $this->json('POST', route('api.users.avatars.store', $user->name), [
            'avatar' => $oldAvatar
        ]);

        $newAvatar = UploadedFile::fake()->image('newavatar.jpg');

        $this->json('POST', route('api.users.avatars.store', $user->name), [
            'avatar' => $newAvatar
        ]);
        
        Storage::disk('public')->assertExists("avatars/{$newAvatar->hashName()}");

        Storage::disk('public')->assertMissing("avatars/{$oldAvatar->hashName()}");
    }

    /** @test */
    public function a_user_can_delete_her_avatar()
    {
        $user = $this->signIn();

        Storage::fake('public');

        $oldAvatar = UploadedFile::fake()->image('avatar.jpg');

        $this->json('POST', route('api.users.avatars.store', $user->name), [
            'avatar' => $oldAvatar
        ]);

        $this->json('DELETE', route('api.users.avatars.delete', $user->name));

        Storage::disk('public')->assertMissing("avatars/{$oldAvatar->hashName()}");

        $this->assertEquals('/storage/avatars/notfound.jpg', $user->avatar_path);
    }
}
