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
            'photo' => 'Not an image'
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

    /** @test */
    public function a_user_can_change_order_of_photos()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        $firstPhoto = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 1
        ]);
        
        $secondPhoto = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 2
        ]);
                
        $secondPhoto = create(Photo::class, [
            'order' => 1
        ]);

        $this->json('PATCH', route('api.photos.order.update', $advert->slug), [
            'photos' => '2, 1'
        ]);

        $response = $this->getJson(route('adverts.show', [$advert->city->slug, $advert->slug]))->json();

        $this->assertEquals([2, 1], array_column($response['photos'], 'id'));
    }


    /** @test */
    public function order_can_be_only_changed_on_photos_which_belongs_to_an_advert()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        $firstPhoto = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 1
        ]);
        
        $secondPhoto = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 2
        ]);
                
        $notBelongsToAnAdvert = create(Photo::class, [
            'order' => 1
        ]);

        $this->json('PATCH', route('api.photos.order.update', $advert->slug), [
            'photos' => '2, 1, 3'
        ]);

        $response = $this->getJson(route('adverts.show', [$advert->city->slug, $advert->slug]))->json();

        $this->assertEquals([2, 1], array_column($response['photos'], 'id'));
    }

    /** @test */
    public function a_user_can_add_photos_to_existing_advert()
    {
        $this->withoutExceptionHandling();

        Storage::fake('public');

        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        create(Photo::class, [
            'advert_id' => $advert->id
        ]);

        $file = UploadedFile::fake()->image('photo.jpg');

        $upload = $this->json('PATCH', route('api.adverts.photos.update', $advert->slug), [
            'photo' => $file
        ])->decodeResponseJson();

        $this->assertArrayHasKey('url', $upload);
        $this->assertArrayHasKey('id', $upload);;

        $this->assertCount(2, $advert->photos);
    }

    /** @test */
    public function uploaded_photo_must_determine_its_order()
    {
        $this->withoutExceptionHandling();

        Storage::fake('public');

        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        create(Photo::class, [
            'advert_id' => $advert->id
        ]);

        $file = UploadedFile::fake()->image('photozz.jpg');

        $upload = $this->json('PATCH', route('api.adverts.photos.update', $advert->slug), [
            'photo' => $file
        ])->decodeResponseJson();
        
        $this->assertEquals(1, $advert->photos->last()->order);
    }
}
