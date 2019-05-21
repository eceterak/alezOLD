<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Facades\Tests\Setup\AdvertFactory;
use App\Advert;

class PhotosUploadTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function upload_photo_alternative()
    {
        Storage::fake('public');

        $this->signIn();

        $this->get(route('adverts.create'));

        $file = UploadedFile::fake()->image('photo.jpg');

        $upload = $this->json('POST', route('api.adverts.photos.store'), [
            'photo' => $file
        ])->decodeResponseJson();

        $this->assertArrayHasKey('url', $upload);
        $this->assertArrayHasKey('id', $upload);

        $this->post(route('adverts.store'), AdvertFactory::raw([
            'photos' => $upload['id']
        ]));

        $advert = Advert::first();

        $this->assertCount(1, $advert->photos);
        
    }

    /** @test */
    public function a_valid_photo_must_be_provided()
    {
        $user = $this->signIn();

        $response = $this->json('POST', route('api.adverts.photos.store'), [
            'avatar' => 'Not an image'
        ])->assertStatus(422);
    }

    public function only_members_can_add_avatars()
    {
        $response = $this->json('POST', route('api.users.avatars.store', 'john'))->assertStatus(401);
    }
}
