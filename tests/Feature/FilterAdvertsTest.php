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
    public function adverts_can_be_ordered_by_rent()
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

    /** @test */
    public function adverts_can_be_filtered_by_minimum_and_maximum_rent()
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

        $response = $this->getJson(route('cities.show', [$advertWithHighRent->city->slug, 'rentmin' => 300]))->json();
        $this->assertNotContains(200, array_column($response['data'], 'rent'));

        $response = $this->getJson(route('cities.show', [$advertWithHighRent->city->slug, 'rentmax' => 600]))->json();
        $this->assertNotContains(1000, array_column($response['data'], 'rent'));
    }

    /** @test */
    public function adverts_can_be_filtered_by_room_size()
    {
        $city = create(City::class);

        $advertWithSingleRoom = AdvertFactory::city($city)->create([
            'room_size' => 'single'
        ]);

        $advertWithDoubleRoom = AdvertFactory::city($city)->create([
            'room_size' => 'double'
        ]);

        $advertWithTripleRoom = AdvertFactory::city($city)->create([
            'room_size' => 'triple'
        ]);

        $response = $this->getJson(route('cities.show', [$advertWithSingleRoom->city->slug, 'roomsize' => 'single']))->json();

        $this->assertCount(1, $response['data']);

        $response = $this->getJson(route('cities.show', [$advertWithSingleRoom->city->slug, 'roomsize' => 'double']))->json();

        $this->assertCount(1, $response['data']);

        $response = $this->getJson(route('cities.show', [$advertWithSingleRoom->city->slug, 'roomsize' => 'triple']))->json();

        $this->assertCount(1, $response['data']);
    }
        
    /** @test */
    public function adverts_can_be_filtered_by_availability()
    {
        $city = create(City::class);

        $date = \Carbon\Carbon::now();

        $advertAvailableNow = AdvertFactory::city($city)->create([
            'available_from' => $date,
        ]);

        $advertAvailableIn30Days = AdvertFactory::city($city)->create([
            'available_from' => $date->copy()->addDays(5),
        ]);

        $advertAvailableIn90Days = AdvertFactory::city($city)->create([
            'available_from' => $date->copy()->addDays(80),
        ]);

        $response = $this->getJson(route('cities.show', [$city->slug, 'availability' => 'now']))->json();
        $this->assertCount(1, $response['data']);
        $this->assertContains($advertAvailableNow->title, array_column($response['data'], 'title'));

        $response = $this->getJson(route('cities.show', [$city->slug, 'availability' => 30]))->json();
        $this->assertCount(2, $response['data']);
        $this->assertNotContains($advertAvailableIn90Days->title, array_column($response['data'], 'title'));

        $response = $this->getJson(route('cities.show', [$city->slug, 'availability' => 90]))->json();
        $this->assertCount(3, $response['data']);
    }

    /** @test */
    public function adverts_can_be_filtered_by_gender()
    {
        $city = create(City::class);

        $advertFemaleOnly = AdvertFactory::city($city)->create([
            'gender' => 'f',
            'couples' => false
        ]);

        $advertMaleOnly = AdvertFactory::city($city)->create([
            'gender' => 'm',
            'couples' => false
        ]);

        $advertForCouples = AdvertFactory::city($city)->create([
            'couples' => true
        ]);

        $this->get(route('cities.show', [$advertFemaleOnly->city->slug, 'gender' => 'f']))
            ->assertSeeText($advertFemaleOnly->title)
            ->assertDontSeeText($advertMaleOnly->title);

        $this->get(route('cities.show', [$advertFemaleOnly->city->slug, 'gender' => 'm']))
            ->assertSeeText($advertMaleOnly->title)
            ->assertDontSeeText($advertFemaleOnly->title);
        
        $this->get(route('cities.show', [$advertFemaleOnly->city->slug, 'gender' => 'couples']))
            ->assertSeeText($advertForCouples->title)
            ->assertDontSeeText($advertMaleOnly->title)
            ->assertDontSeeText($advertFemaleOnly->title);
    }

    /** @test */
    public function adverts_can_be_filtered_by_minimum_and_maximum_stay_duration()
    {
        $city = create(City::class);

        $advertAnyStay = AdvertFactory::city($city)->create([
            'minimum_stay' => null,
            'maximum_stay' => null
        ]);

        
        $advertShortStay = AdvertFactory::city($city)->create([
            'minimum_stay' => 1,
            'maximum_stay' => 36
        ]);

        $advertLongStay = AdvertFactory::city($city)->create([
            'minimum_stay' => 12,
            'maximum_stay' => 24
        ]);
        
        $this->get(route('cities.show', [$advertLongStay->city->slug, 'staymin' => 3]))
            ->assertSeeText($advertShortStay->title)
            ->assertSeeText($advertAnyStay->title)
            ->assertDontSeeText($advertLongStay->title);

        $this->get(route('cities.show', [$advertLongStay->city->slug, 'staymax' => 26]))
            ->assertSeeText($advertAnyStay->title)
            ->assertSeeText($advertLongStay->title)
            ->assertDontSeeText($advertShortStay->title);
    }

    /** @test */
    public function adverts_can_be_filtered_by_occupation()
    {
        $city = create(City::class);

        $advertForStudent = AdvertFactory::city($city)->create([
            'occupation' => 'student'
        ]);

        $advertForProfessional = AdvertFactory::city($city)->create([
            'occupation' => 'professional'
        ]);

        $response = $this->getJson(route('cities.show', [$advertForStudent->city->slug, 'occupation' => 'student']))->json();
        $this->assertCount(1, $response['data']);

        $response = $this->getJson(route('cities.show', [$advertForStudent->city->slug, 'occupation' => 'professional']))->json();
        $this->assertCount(1, $response['data']);
    }
    
    /** @test */
    public function adverts_can_be_filtered_by_minimum_and_maximum_age()
    {
        $city = create(City::class);

        $advertForAny = AdvertFactory::city($city)->create([
            'minimum_age' => null,
            'maximum_age' => null
        ]);

        $advertForOlder = AdvertFactory::city($city)->create([
            'minimum_age' => 50,
            'maximum_age' => 99
        ]);

        $advertForYounger = AdvertFactory::city($city)->create([
            'minimum_age' => 18,
            'maximum_age' => 30
        ]);

        $this->get(route('cities.show', [$city->slug, 'agemin' => 40]))
            ->assertSeeText($advertForOlder->title)
            ->assertSeeText($advertForAny->title)
            ->assertDontSeeText($advertForYounger->title);

        $this->get(route('cities.show', [$city->slug, 'agemin' => 18, 'agemax' => 30]))
            ->assertDontSeeText($advertForOlder->title)
            ->assertSeeText($advertForAny->title)
            ->assertSeeText($advertForYounger->title);
    }
    
    /** @test */
    public function adverts_can_be_filtered_by_furniture()
    {
        $advertWithFurniture = AdvertFactory::create([
            'furnished' => true
        ]);

        $advertWithoutFurniture = AdvertFactory::create([
            'city_id' => $advertWithFurniture->city->id,
            'furnished' => false
        ]);

        $this->get(route('cities.show', [$advertWithFurniture->city->slug, 'furnished' => 1]))
            ->assertSeeText($advertWithFurniture->title)
            ->assertDontSeeText($advertWithoutFurniture->title);
    }

    /** @test */
    public function adverts_can_be_filtered_by_broadband()
    {
        $advertWithBroadband = AdvertFactory::create([
            'broadband' => true
        ]);

        $advertWithoutBroadband = AdvertFactory::create([
            'city_id' => $advertWithBroadband->city->id,
            'broadband' => false
        ]);

        $this->get(route('cities.show', [$advertWithBroadband->city->slug, 'broadband' => 1]))
            ->assertSeeText($advertWithBroadband->title)
            ->assertDontSeeText($advertWithoutBroadband->title);
    }

    /** @test */
    public function adverts_can_be_filtered_by_those_with_parking()
    {
        $city = create(City::class);

        $advertWithParking = AdvertFactory::city($city)->create([
            'parking' => true
        ]);

        $advertWithoutParking= AdvertFactory::city($city)->create([
            'parking' => false
        ]);

        $this->get(route('cities.show', [$city->slug, 'parking' => 1]))
            ->assertSeeText($advertWithParking->title)
            ->assertDontSeeText($advertWithoutParking->title);
    }

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

        $this->get(route('cities.show', [$advertWith->city->slug, 'livingroom' => 1]))
            ->assertSeeText($advertWith->title)
            ->assertDontSeeText($advertWithout->title);
    }

    /** @test */
    public function adverts_can_be_filtered_by_garage()
    {
        $advertWithGarage = AdvertFactory::create([
            'garage' => true
        ]);

        $advertWithoutGarage = AdvertFactory::create([
            'city_id' => $advertWithGarage->city->id,
            'garage' => false
        ]);

        $this->get(route('cities.show', [$advertWithGarage->city->slug, 'garage' => 1]))
            ->assertSeeText($advertWithGarage->title)
            ->assertDontSeeText($advertWithoutGarage->title);
    }

    /** @test */
    public function adverts_can_be_filtered_by_garden()
    {
        $advertWithGarden = AdvertFactory::create([
            'garden' => true
        ]);

        $advertWithoutGarden = AdvertFactory::create([
            'city_id' => $advertWithGarden->city->id,
            'garden' => false
        ]);

        $this->get(route('cities.show', [$advertWithGarden->city->slug, 'garden' => 1]))
            ->assertSeeText($advertWithGarden->title)
            ->assertDontSeeText($advertWithoutGarden->title);
    }

    /** @test */
    public function adverts_can_be_filtered_smoking_preferences()
    {
        $city = create(City::class);

        $advertForSmokers = AdvertFactory::city($city)->create([
            'nonsmoking' => false
        ]);

        $advertForNonSmokers = AdvertFactory::city($city)->create([
            'nonsmoking' => true
        ]);

        $response = $this->getJson(route('cities.show', [$city->slug, 'smoking' => 1]))->json();
        $this->assertContains($advertForSmokers->title, array_column($response['data'], 'title'));
        $this->assertNotContains($advertForNonSmokers->title, array_column($response['data'], 'title'));
    }

    /** @test */
    public function adverts_can_be_filtered_by_those_which_accepts_pets()
    {
        $city = create(City::class);

        $advertAcceptsPets = AdvertFactory::city($city)->create([
            'pets' => true
        ]);

        $advertDoesNotAcceptsPets = AdvertFactory::city($city)->create([
            'pets' => false
        ]);

        $response = $this->getJson(route('cities.show', [$city->slug, 'pets' => 1]))->json();
        $this->assertContains($advertAcceptsPets->title, array_column($response['data'], 'title'));
        $this->assertNotContains($advertDoesNotAcceptsPets->title, array_column($response['data'], 'title'));
    }
}