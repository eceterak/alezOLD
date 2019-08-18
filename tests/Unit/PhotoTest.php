<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Photo;

class PhotoTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->uuid = Str::uuid()->toString();
    }

    /** @test */
    public function it_belongs_to_an_advert()
    {
        $advert = AdvertFactory::create();

        $photo = create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 0
        ]);

        $this->assertEquals($advert->id, $photo->advert->id);
    }

    /** @test */
    public function it_must_be_an_image()
    {
        $user = $this->signIn();

        $response = $this->json('POST', route('api.adverts.photos.store', $this->uuid), [
            'photo' => 'Not an image'
        ])->assertStatus(422);
    }

    /** @test */
    public function a_photo_cannot_be_over_4_mb()
    {
        $user = $this->signIn();

        $file = UploadedFile::fake()->image('photo.jpg')->size(4001);

        $upload = $this->json('POST', route('api.adverts.photos.store', $this->uuid), [
            'photo' => $file
        ])->assertJsonValidationErrors('photo');
    }
}
