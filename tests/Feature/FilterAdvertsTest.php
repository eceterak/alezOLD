<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\City;

class FilterAdvertsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function adverts_can_be_filtered_by_living_room()
    {
        $advertWith = AdvertFactory::create([
            'living_room' => 1
        ]);

        $advertWithout = AdvertFactory::create([
            'city_id' => $advertWith->city->id,
            'living_room' => 0
        ]);

        $response = $this->get(route('cities.show', [$advertWith->city->slug, 'livingroom' => 1]))
        ->assertSee($advertWith->title)
        ->assertDontSee($advertWithout->title);
    }

    /** @test */
    public function aadverts_can_be_ordered_by_rent_asc_and_desc()
    {
        $city = create(City::class);

        $advertWithHighRent = AdvertFactory::city($city)->create([
            'rent' => 1000
        ]);

        $advertWithAverageRent = AdvertFactory::city($city)->create([
            'rent' => 500
        ]);

        $advertWithLowRent = AdvertFactory::city($city)->create([
            'rent' => 200
        ]);

        $response = $this->getJson(route('cities.show', [$advertWithHighRent->city->slug, 'sort' => 'rent_desc']))->json();

        $this->assertEquals([1000, 500, 200], array_column($response['data'], 'rent'));

        $response = $this->getJson(route('cities.show', [$advertWithHighRent->city->slug, 'sort' => 'rent_asc']))->json();

        $this->assertEquals([200, 500, 1000], array_column($response['data'], 'rent'));
    }
}
