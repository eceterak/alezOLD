<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\Advert;
use App\City;

class CitiesDisplayTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_adverts_from_a_specific_city() 
    {
        $city = create(City::class);

        $advertInCity = create(Advert::class, [
            'user_id' => $this->user(),
            'city_id' => $city->id
        ]);

        $this->get(route('cities.show', $city->slug))->assertSee($advertInCity->title);               
    }

    /** @test */
    public function a_user_can_increase_search_radius_by_5_km_to_include_more_cities() 
    {
        $city = create(City::class, [
            'lat' => 50,
            'lon' => 20
        ]);

        $city5kmAway = create(City::class, [
            'lat' => 49.972719,
            'lon' => 19.974723
        ]);

        $advertInCity = create(Advert::class, [
            'user_id' => $this->user(),
            'city_id' => $city->id
        ]);

        $advertInCity5kmAway = create(Advert::class, [
            'user_id' => $this->user(),
            'city_id' => $city5kmAway->id
        ]);

        $this->get(route('cities.show', [$city->slug, 'radius' => 5]))->assertSee($advertInCity5kmAway->title);
        $this->get(route('cities.show', [$city->slug, 'radius' => 5]))->assertSee($advertInCity->title);
    }

    /** @test */
    public function a_user_can_increase_search_radius_by_10_km_to_include_more_cities() 
    {
        $city = create(City::class, [
            'lat' => 50,
            'lon' => 20
        ]);

        $city10kmAway = create(City::class, [
            'lat' => 50.055712,
            'lon' => 19.946743
        ]);

        $advertInCity10kmAway = create(Advert::class, [
            'user_id' => $this->user(),
            'city_id' => $city10kmAway->id
        ]);

        $this->get(route('cities.show', [$city->slug, 'radius' => 10]))->assertSee($advertInCity10kmAway->title);
    }

    /** @test */
    public function a_user_can_increase_search_radius_by_15_km_to_include_more_cities() 
    {
        $city = create(City::class, [
            'lat' => 50,
            'lon' => 20
        ]);

        $city15kmAway = create(City::class, [
            'lat' => 49.975764, 
            'lon' => 20.198330
        ]);

        $advertInCity15kmAway = create(Advert::class, [
            'user_id' => $this->user(),
            'city_id' => $city15kmAway->id
        ]);

        $this->get(route('cities.show', [$city->slug, 'radius' => 15]))->assertSee($advertInCity15kmAway->title);
    }

    /** @test */
    public function a_user_can_increase_search_radius_by_25_km_to_include_more_cities() 
    {
        $city = create(City::class, [
            'lat' => 50,
            'lon' => 20
        ]);

        $city25kmAway = create(City::class, [
            'lat' => 49.970466,
            'lon' => 20.321028
        ]);

        $advertInCity25kmAway = create(Advert::class, [
            'user_id' => $this->user(),
            'city_id' => $city25kmAway->id
        ]);

        $this->get(route('cities.show', [$city->slug, 'radius' => 25]))->assertSee($advertInCity25kmAway->title);
    }

    /** @test */
    public function a_user_can_increase_search_radius_by_50_km_to_include_more_cities() 
    {
        $city = create(City::class, [
            'lat' => 50,
            'lon' => 20
        ]);

        $city50kmAway = create(City::class, [
            'lat' => 49.819018, 
            'lon' => 20.594075
        ]);

        $advertInCity50kmAway = create(Advert::class, [
            'user_id' => $this->user(),
            'city_id' => $city50kmAway->id
        ]);

        $this->get(route('cities.show', [$city->slug, 'radius' => 50]))->assertSee($advertInCity50kmAway->title);
    }

    /** @test */
    public function adverts_from_cities_out_of_search_radius_should_not_be_included() 
    {
        $city = create(City::class, [
            'lat' => 50,
            'lon' => 20
        ]);

        $city50kmAway = create(City::class, [
            'lat' => 49.819018, 
            'lon' => 20.594075
        ]);

        $advertInCity50kmAway = create(Advert::class, [
            'user_id' => $this->user(),
            'city_id' => $city50kmAway->id
        ]);

        $this->get(route('cities.show', [$city->slug, 'radius' => 5]))->assertDontSee($advertInCity50kmAway->title);
    }

    /** @test */
    public function adverts_from_other_cities_shouldnt_be_visible_in_the_city()
    {
        $this->withoutExceptionHandling();

        $city = create(City::class);

        $advertNotInCity = AdvertFactory::create();

        $this->get(route('cities.show', $city->slug))->assertDontSee($advertNotInCity->title); 
    }

    /** @test */
    public function unverified_adverts_should_not_be_listed()
    {
        $advert = AdvertFactory::create([
            'verified' => false
        ]);

        $this->get(route('cities.show', $advert->city->slug))->assertDontSee($advert->title); 
    }

    /** @test */
    public function archived_adverts_are_should_not_be_listed()
    {
        $advert = AdvertFactory::create();

        $advert->archive();

        $this->get(route('cities.show', $advert->city->slug))->assertDontSee($advert->title); 
    }

    /** @test */
    public function show_suggested_cities_on_main_page()
    {
            $citySuggested = create(City::class, [
                'suggested' => true
            ]);

            $this->get(route('index'))->assertSee($citySuggested->name);
    }

    /** @test */
    public function dont_show_nonsuggested_cities_on_main_page()
    {
        $cityNotSuggested = create(City::class, [
            'suggested' => false
        ]);

        $this->get(route('index'))->assertDontSee($cityNotSuggested->name);
    }
}
