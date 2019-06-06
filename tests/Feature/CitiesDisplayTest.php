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
    public function adverts_from_other_cities_shouldnt_be_visible_in_the_city()
    {
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
