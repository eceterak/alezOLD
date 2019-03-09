<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdvertTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_advert_belongs_to_an_owner()
    {
        $this->authenticated();;

        $advert = factory('App\Advert')->create(['user_id' => auth()->id()]);

        $this->assertInstanceOf('App\User', $advert->user);

        //$this->assertEquals(auth()->user(), $advert->user);

    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_has_a_path()
    {
        $advert = factory('App\Advert')->create();

        $advert->path();

        $this->assertEquals('/pokoje/'.$advert->id, $advert->path());
    }
}
