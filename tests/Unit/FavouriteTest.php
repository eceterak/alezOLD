<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;

class FavouriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_favourite_anything_that_uses_trait()
    {
        $this->signIn();

        $advert = AdvertFactory::create();

        $advert->favourite();

        $this->assertCount(1, $advert->favourites);
    }

    /** @test */
    public function it_can_unfavourite_anything_that_uses_trait()
    {
        $this->signIn();

        $advert = AdvertFactory::create();

        $advert->favourite();
        $advert->unfavourite();

        $this->assertCount(0, $advert->favourites);

    }

}
