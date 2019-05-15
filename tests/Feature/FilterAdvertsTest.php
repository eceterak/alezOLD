<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use Facades\Tests\Setup\WorldFactory;
use App\Street;
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

        $response = $this->get(route('cities.show', $advertWith->city->slug).'?livingroom=1')
        ->assertSee($advertWith->title)
        ->assertDontSee($advertWithout->title);
    }

    /** @test */
    public function aadverts_can_be_ordered_by_rent()
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

        $response = $this->getJson(route('cities.show', $advertWithHighRent->city->slug).'?rent=desc')->json();

        $this->assertEquals([1000, 500, 200], array_column($response['data'], 'rent'));
    }
}
