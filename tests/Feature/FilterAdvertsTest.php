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
    public function adverts_can_be_ordered_by_rent_asc_and_desc()
    {
        $this->withoutExceptionHandling();

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
    public function adverts_can_be_filtered_by_minimum_and_maximum_stay()
    {
        $this->withoutExceptionHandling();

        $city = create(City::class);

        $advertLongStay = AdvertFactory::city($city)->create([
            'minimum_stay' => 1,
            'maximum_stay' => 36
        ]);

        $advertWithAverageStay = AdvertFactory::city($city)->create([
            'minimum_stay' => 3,
            'maximum_stay' => 12
        ]);

        $advertWithShortStay = AdvertFactory::city($city)->create([
            'minimum_stay' => 1,
            'maximum_stay' => 3
        ]);

        $response = $this->getJson(route('cities.show', [$advertLongStay->city->slug, 'staymin' => 3]))->json();

        $this->assertCount(1, $response['data']);

        $response = $this->getJson(route('cities.show', [$advertLongStay->city->slug, 'staymax' => 12]))->json();

        $this->assertNotContains(36, array_column($response['data'], 'maximum_stay'));
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
    public function adverts_can_be_filtered_by_gender()
    {
        $city = create(City::class);

        $advertFemaleOnly = AdvertFactory::city($city)->create([
            'gender' => 'f'
        ]);

        $advertMaleOnly = AdvertFactory::city($city)->create([
            'gender' => 'm'
        ]);

        $response = $this->getJson(route('cities.show', [$advertFemaleOnly->city->slug, 'gender' => 'f']))->json();

        $this->assertCount(1, $response['data']);

        $response = $this->getJson(route('cities.show', [$advertFemaleOnly->city->slug, 'gender' => 'm']))->json();

        $this->assertCount(1, $response['data']);
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

        $advertForOlder = AdvertFactory::city($city)->create([
            'minimum_age' => 50,
            'maximum_age' => 99
        ]);

        $advertForAnyone = AdvertFactory::city($city)->create([
            'minimum_age' => 1,
            'maximum_age' => 50
        ]);

        $advertForYounger = AdvertFactory::city($city)->create([
            'minimum_age' => 1,
            'maximum_age' => 20
        ]);

        $response = $this->getJson(route('cities.show', [$city->slug, 'agemin' => 40]))->json();

        $this->assertNotContains(1, array_column($response['data'], 'minimum_age'));

        $response = $this->getJson(route('cities.show', [$city->slug, 'agemax' => 50]))->json();

        $this->assertNotContains(99, array_column($response['data'], 'maximum_age'));
    }
    
    /** @test */
    public function adverts_can_be_filtered_availability()
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
    public function adverts_can_be_filtered_smoking_preferences()
    {
        $city = create(City::class);

        $advertForNonSmokers = AdvertFactory::city($city)->create([
            'smoking' => 'n'
        ]);

        $advertForSmokers = AdvertFactory::city($city)->create([
            'smoking' => 'y'
        ]);

        $response = $this->getJson(route('cities.show', [$city->slug, 'smoking' => 'nonsmokers']))->json();

        $this->assertNotContains($advertForSmokers->title, array_column($response['data'], 'title'));

        $response = $this->getJson(route('cities.show', [$city->slug, 'smoking' => 'smokers']))->json();

        $this->assertNotContains($advertForNonSmokers->title, array_column($response['data'], 'title'));
    }

    /** @test */
    public function adverts_can_be_filtered_by_those_which_accepts_pats()
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

        $response = $this->getJson(route('cities.show', [$city->slug]))->json();

        $this->assertCount(2, $response['data']);
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

        $response = $this->getJson(route('cities.show', [$city->slug, 'parking' => 1]))->json();

        $this->assertContains($advertWithParking->title, array_column($response['data'], 'title'));
        $this->assertNotContains($advertWithoutParking->title, array_column($response['data'], 'title'));

        $response = $this->getJson(route('cities.show', [$city->slug]))->json();

        $this->assertCount(2, $response['data']);
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

        $response = $this->get(route('cities.show', [$advertWith->city->slug, 'livingroom' => 1]))
            ->assertSee($advertWith->title)
            ->assertDontSee($advertWithout->title);
    }

    /** @test */
    public function admin_can_filter_adverts_by_verification_status()
    {
        $this->signInAdmin();

        $verifiedAdvert = AdvertFactory::create([
            'verified' => true
        ]);

        $unVerifiedAdvert = AdvertFactory::create([
            'verified' => false
        ]);

        $this->get(route('admin.adverts', ['verified' => 'n']))
            ->assertSee($unVerifiedAdvert->title)
            ->assertDontSee($verifiedAdvert->title);

        $this->get(route('admin.adverts', ['verified' => 'y']))
            ->assertSee($verifiedAdvert->title)
            ->assertDontSee($unVerifiedAdvert->title);
    }

    /** @test */
    public function admin_can_filter_adverts_by_revision_status()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $advert = AdvertFactory::create([
            'revision' => null
        ]);

        $advertWithRevision = AdvertFactory::create([
            'revision' => [
                'title' => 'asd'
            ]
        ]);

        $this->get(route('admin.adverts', ['revised' => 'y']))
            ->assertSee($advert->title)
            ->assertDontSee($advertWithRevision->title);

        $this->get(route('admin.adverts', ['revised' => 'n']))
            ->assertSee($advertWithRevision->title)
            ->assertDontSee($advert->title);
    }

    /** @test */
    public function admin_can_filter_adverts_by_archivision_status()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $advert = AdvertFactory::create([
            'archived' => false
        ]);

        $archivedAdvert = AdvertFactory::create([
            'archived' => true
        ]);

        $this->get(route('admin.adverts', ['archived' => 'y']))
            ->assertSee($archivedAdvert->title)
            ->assertDontSee($advert->title);

        $this->get(route('admin.adverts', ['archived' => 'n']))
            ->assertSee($advert->title)
            ->assertDontSee($archivedAdvert->title);
    }
}
