<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;
use App\Street;
use App\Advert;

class CityTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function city_requires_a_name()
    {
        $this->signInAdmin();

        $this->post(route('admin.cities.store'), raw(City::class, [
            'name' => ''
        ]))->assertSessionHasErrors('name');
    }

    /** @test */
    public function city_requires_latitude_and_longtitute()
    {
        $this->signInAdmin();

        $this->post(route('admin.cities.store'), raw(City::class, [
            'lat' => '',
            'lon' => '',
        ]))->assertSessionHasErrors(['lat', 'lon']);
    }

    /** @test */
    public function city_requires_a_county_and_a_state()
    {
        $this->signInAdmin();

        $this->post(route('admin.cities.store'), raw(City::class, [
            'county' => '',
            'state' => ''
        ]))->assertSessionHasErrors(['county', 'state']);
    }

    /** @test */
    public function can_create_a_slug()
    {
        $city = create(City::class);

        $city->createSlug();

        $this->assertEquals(str_slug($city->name), $city->slug);
    }

    /** @test */
    public function city_has_a_slug() 
    {
        $city = create(City::class);
        
        $this->assertIsString($city->slug);
    }

    /** @test */
    public function city_has_streets()
    {
        $city = create(City::class);

        $street = create(Street::class, [
            'city_id' => $city->id
        ]);

        $this->assertTrue($city->streets->contains($street));
    }

    /** @test */
    public function city_has_adverts() 
    {
        $city = create(City::class);

        $advert = create(Advert::class, [
            'user_id' => $this->user(),
            'city_id' => $city->id
        ]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $city->adverts);
    }

    /** @test */
    public function city_can_be_subscribed_to()
    {
        $user = $this->signIn();

        $city = create(City::class);

        $city->subscribe();

        $this->assertEquals(1, $city->subscriptions()->where('user_id', auth()->user()->id)->count());
    }

    /** @test */
    public function city_can_be_unsubscribed_from()
    {
        $user = $this->signIn();

        $city = create(City::class);

        $city->subscribe();

        $city->unsubscribe();

        $this->assertCount(0, $city->subscriptions);
    }

    /** @test */
    public function it_knows_if_authenticated_user_is_subscribed_to()
    {
        $user = $this->signIn();

        $city = create(City::class);

        $city->subscribe();

        $this->assertTrue($city->isSubscribed);
    }
}
