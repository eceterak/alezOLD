<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Facades\Tests\Setup\AdvertFactory;
use App\Advert;
use App\Photo;

class PhotosUploadTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function user_can_upload_a_photo_when_creating_a_new_advert()
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

        Storage::disk('public')->assertExists("photos/{$file->hashName()}");

        $this->post(route('adverts.store'), AdvertFactory::raw([
            'photos' => $upload['id']
        ]));

        $advert = Advert::first();

        $this->assertCount(1, $advert->photos);
    }

    /** @test */
    public function when_creating_an_advert_first_uploaded_photo_is_always_a_featured_one()
    {
        $this->signIn();

        $featuredPhoto = Photo::create([
            'url' => 'photos/featured.jpg'
        ]);
        $standardPhoto = Photo::create([
            'url' => 'photos/standard.jpg'
        ]);

        $this->post(route('adverts.store'), AdvertFactory::raw([
            'photos' => "{$featuredPhoto->id}, {$standardPhoto->id}"
        ]));

        $advert = Advert::first();

        $this->assertCount(2, $advert->photos);

        $this->assertEquals('/storage/photos/featured.jpg', $advert->featured_photo_path);
    }

    /** @test */
    public function a_valid_photo_must_be_provided()
    {
        $user = $this->signIn();

        $response = $this->json('POST', route('api.adverts.photos.store'), [
            'avatar' => 'Not an image'
        ])->assertStatus(422);
    }

    /** @test */
    public function a_photo_cannot_be_over_3_mb()
    {
        $user = $this->signIn();

        $file = UploadedFile::fake()->image('photo.jpg')->size(5000);

        $upload = $this->json('POST', route('api.adverts.photos.store'), [
            'photo' => $file
        ])->assertJsonValidationErrors('photo');
    }

    /** @test */
    public function only_members_can_add_photos()
    {
        $response = $this->json('POST', route('api.adverts.photos.store'))->assertStatus(401);
    }

    /** @test */
    public function a_photo_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        Storage::fake('public');

        $this->signIn();

        $file = UploadedFile::fake()->image('photo.jpg');

        $upload = $this->json('POST', route('api.adverts.photos.store'), [
            'photo' => $file
        ])->decodeResponseJson();

        $this->assertCount(1, Photo::all());

        $this->json('DELETE', route('api.adverts.photos.delete', $upload['id']));

        $this->assertCount(0, Photo::all());

        Storage::disk('public')->assertMissing("photos/{$file->hashName()}");
    }
}
