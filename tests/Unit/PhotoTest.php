<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\Photo;

class PhotoTest extends TestCase
{
    use RefreshDatabase;

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
}
