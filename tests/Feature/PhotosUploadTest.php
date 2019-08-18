<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Facades\Tests\Setup\AdvertFactory;
use App\Advert;
use App\Photo;
use Illuminate\Support\Str;

class PhotosUploadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->uuid = Str::uuid()->toString();
    }

    /** @test */
    public function user_can_upload_a_photo_when_creating_a_new_advert()
    {
        Storage::fake('s3');

        $this->signIn();

        $file = UploadedFile::fake()->image('photo.jpg');

        $upload = $this->json('POST', route('api.adverts.photos.store', $this->uuid), [
            'photo' => $file
        ])->assertStatus(200)->decodeResponseJson();

        $this->assertArrayHasKey('url', $upload);
        $this->assertArrayHasKey('id', $upload);

        Storage::disk('s3')->assertExists("photos/{$file->hashName()}");

        $this->post(route('adverts.store'), AdvertFactory::raw([
            'photos' => $upload['id']
        ]));

        $advert = Advert::first();

        $this->assertCount(1, $advert->photos);
    }

    /** @test */
    public function a_user_can_more_than_to_7_photos_to_a_new_advert()
    {
        $this->signIn();

        $photos = create(Photo::class, [
            'temp' => $this->uuid
        ], 7);

        $upload = $this->json('POST', route('api.adverts.photos.store', $this->uuid), [
            'photo' => 'something'
        ])->assertStatus(500)->decodeResponseJson();

        $this->assertEquals($upload['message'], 'Możesz dodać maksymalnie 7 zdjęć.');
    }

    /** @test */
    public function when_creating_an_advert_first_uploaded_photo_is_always_a_featured_one()
    {
        $this->signIn();

        $featuredPhoto = create(Photo::class, [
            'url' => 'photos/featured.jpg'
        ]);

        $standardPhoto = create(Photo::class, [
            'temp' => $featuredPhoto->temp
        ]);

        $this->post(route('adverts.store'), AdvertFactory::raw([
            'photos' => "{$featuredPhoto->id}, {$standardPhoto->id}"
        ]));

        $advert = Advert::first();

        $this->assertCount(2, $advert->photos);

        $this->assertEquals('https://alez.s3.eu-central-1.amazonaws.com/photos/featured.jpg', $advert->featured_photo_path);
    }

    /** @test */
    public function only_members_can_add_photos()
    {
        $response = $this->json('POST', route('api.adverts.photos.store', $this->uuid))->assertStatus(401);
    }

    /** @test */
    public function a_photo_can_be_deleted_while_creating_a_new_advert()
    {
        Storage::fake('s3');

        $this->signIn();

        $file = UploadedFile::fake()->image('photo.jpg');

        $upload = $this->json('POST', route('api.adverts.photos.store', $this->uuid), [
            'photo' => $file
        ])->decodeResponseJson();
        
        $photo = Photo::first();

        Storage::disk('s3')->assertExists("photos/{$file->hashName()}");
        
        $this->json('DELETE', route('api.adverts.photos.delete', [$upload['id'], $this->uuid]))->assertStatus(200);
        
        Storage::disk('s3')->assertMissing("photos/{$file->hashName()}");
        
        $this->assertDatabaseMissing('photos', $photo->toArray());
    }

    /** @test */
    public function photo_can_not_be_deleted_while_creating_a_new_advert_and_provided_a_wrong_token()
    {
        Storage::fake('s3');

        $this->signIn();

        $file = UploadedFile::fake()->image('photo.jpg');

        $upload = $this->json('POST', route('api.adverts.photos.store', $this->uuid), [
            'photo' => $file
        ])->decodeResponseJson();

        $response = $this->json('DELETE', route('api.adverts.photos.delete', [$upload['id'], 'some-fake-token']))->assertStatus(500);
    }

    /** @test */
    public function a_photo_of_an_existing_advert_can_be_deleted()
    {
        Storage::fake('s3');

        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        $file = UploadedFile::fake()->image('photo.jpg');

        $upload = $this->json('PATCH', route('api.adverts.photos.update', $advert->slug), [
            'photo' => $file
        ])->decodeResponseJson();

        Storage::disk('s3')->assertExists("photos/{$file->hashName()}");

        $this->assertCount(1, $advert->photos);
        
        $this->json('DELETE', route('api.adverts.photos.delete', [$upload['id'], $this->uuid]))->assertStatus(200);

        Storage::disk('s3')->assertMissing("photos/{$file->hashName()}");
        
        $this->assertCount(0, $advert->fresh()->photos);      
    }

    /** @test */
    public function only_an_owner_can_delete_a_photo_from_existing_advert()
    {
        $this->signIn();

        $advert = AdvertFactory::create();

        $photo = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 0
        ]);

        $this->json('DELETE', route('api.adverts.photos.delete', [$photo->id, $this->uuid]))->assertStatus(403);        
    }

    /** @test */
    public function when_photo_is_deleted_order_of_the_other_photos_is_updated()
    {
        Storage::fake('s3');

        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        $firstPhoto = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 0
        ]);
        
        $secondPhoto = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 1
        ]);

        $thirdPhoto = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 2
        ]);

        $this->json('DELETE', route('api.adverts.photos.delete', [$firstPhoto->id, $this->uuid]));

        $this->assertEquals([0, 1], array_column($advert->photos->toArray(), 'order'));
    }

    /** @test */
    public function a_user_can_change_order_of_photos()
    {
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

        $this->json('PATCH', route('api.photos.order.update', $advert->slug), [
            'photos' => "{$secondPhoto->id}, {$firstPhoto->id}"
        ]);

        $response = $this->getJson(route('adverts.show', [$advert->city->slug, $advert->slug]))->json();
        
        $this->assertEquals([$secondPhoto->id, $firstPhoto->id], array_column($response['photos'], 'id'));
    }


    /** @test */
    public function order_can_be_only_changed_on_photos_which_belongs_to_an_advert()
    {
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
                
        $doesNotBelongsToAnAdvert = create(Photo::class, [
            'order' => 1
        ]);

        $this->json('PATCH', route('api.photos.order.update', $advert->slug), [
            'photos' => "{$secondPhoto->id}, {$firstPhoto->id}, {$doesNotBelongsToAnAdvert->id}"
        ]);

        $response = $this->getJson(route('adverts.show', [$advert->city->slug, $advert->slug]))->json();

        $this->assertEquals([$secondPhoto->id, $firstPhoto->id], array_column($response['photos'], 'id'));
    }

    /** @test */
    public function a_user_can_add_photos_to_existing_advert()
    {
        Storage::fake('s3');

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
        $this->assertArrayHasKey('id', $upload);

        Storage::disk('s3')->assertExists("photos/{$file->hashName()}");

        $this->assertCount(2, $advert->photos);
    }

    /** @test */
    public function a_user_can_add_more_than_7_photos_to_an_existing_advert()
    {
        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        create(Photo::class, [
            'advert_id' => $advert->id
        ], 7);

        $file = UploadedFile::fake()->image('photo.jpg');

        $upload = $this->json('PATCH', route('api.adverts.photos.update', $advert->slug), [
            'photo' => $file
        ])->assertStatus(500)->decodeResponseJson();

        $this->assertArrayHasKey('status', $upload);

        $this->assertCount(7, $advert->photos);
    }

    /** @test */
    public function only_an_owner_can_add_photos_to_existing_advert()
    {
        $this->signIn();

        $advert = AdvertFactory::create();

        $upload = $this->json('PATCH', route('api.adverts.photos.update', $advert->slug))->assertStatus(403);
    }

    /** @test */
    public function uploaded_photo_must_determine_its_order()
    {
        Storage::fake('s3');

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

    /** @test */
    public function if_adverts_exists_and_user_add_a_first_photo_its_order_should_be_0()
    {
        Storage::fake('s3');

        $user = $this->signIn();

        $advert = AdvertFactory::ownedBy($user)->create();

        $file = UploadedFile::fake()->image('photozz.jpg');

        $upload = $this->json('PATCH', route('api.adverts.photos.update', $advert->slug), [
            'photo' => $file
        ])->decodeResponseJson();
        
        $this->assertEquals(0, $advert->photos->last()->order);
    }

    /** @test */
    public function admin_can_verify_a_photo()
    {        
        $this->signInAdmin();

        $advert = AdvertFactory::create();

        $photo = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 0,
            'verified' => false
        ]);

        $this->json('PATCH', route('api.photos.verify', $photo->id))->assertStatus(200);

        $this->assertTrue($photo->fresh()->verified);
    }

    /** @test */
    public function admin_can_verify_all_photos_at_once()
    {
        $this->signInAdmin();

        $advert = AdvertFactory::create();

        create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 0,
            'verified' => false
        ], 5);

        $this->json('POST', route('api.photos.verify.bulk', $advert->slug))->assertStatus(200);

        $advert->photos->each(function($photo) 
        {
            $this->assertTrue($photo->verified);
        });
    }

    /** @test */
    public function only_admin_can_verify_a_photo()
    {
        $advert = AdvertFactory::create();

        $photo = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 0,
            'verified' => false
        ]);

        $this->json('PATCH', route('api.photos.verify', $photo->id))->assertRedirect(route('admin.login'));

        $this->signIn();

        $this->json('PATCH', route('api.photos.verify', $photo->id))->assertRedirect(route('index'));
    }

    /** @test */
    public function only_admin_can_verify_all_photos_at_once()
    {
        $advert = AdvertFactory::create();

        $this->json('POST', route('api.photos.verify.bulk', $advert->slug))->assertRedirect(route('admin.login'));
        
        $this->signIn();
        
        $this->json('POST', route('api.photos.verify.bulk', $advert->slug))->assertRedirect(route('index'));
    }
}