<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\CityFactory;
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

        $this->post(route('admin.cities.store'), factory(City::class)->raw([
            'name' => ''
        ]))->assertSessionHasErrors('name');
    }

    /** @test */
    public function city_requires_latitude_and_longtitute()
    {
        $this->signInAdmin();

        $this->post(route('admin.cities.store'), factory(City::class)->raw([
            'lat' => '',
            'lon' => '',
        ]))->assertSessionHasErrors(['lat', 'lon']);
    }

    /** @test */
    public function city_requires_a_county_and_a_state()
    {
        $this->signInAdmin();

        $this->post(route('admin.cities.store'), factory(City::class)->raw([
            'county' => '',
            'state' => ''
        ]))->assertSessionHasErrors(['county', 'state']);
    }

    /** @test */
    public function can_create_a_slug()
    {
        $city = CityFactory::create();

        $city->createSlug();

        $this->assertEquals(str_slug($city->name), $city->slug);
    }

    /** @test */
    public function city_has_a_slug() 
    {
        $city = factory(City::class)->create();
        
        $this->assertIsString($city->slug);
    }

    /** @test */
    public function city_has_streets()
    {
        $city = factory(City::class)->create();

        $street = factory(Street::class)->create([
            'city_id' => $city->id
        ]);

        $this->assertTrue($city->streets->contains($street));
    }

    /** @test */
    public function city_has_adverts() 
    {
        $city = factory(City::class)->create();

        $advert = factory(Advert::class)->create([
            'user_id' => $this->user(),
            'city_id' => $city->id
        ]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $city->adverts);
    }
}
