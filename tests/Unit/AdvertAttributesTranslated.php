<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;

class AdvertAttributesTranslated extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->advert = AdvertFactory::create();
    }
 
    /** @test */
    public function t_will_fetch_bills_attribute_as_integer()
    {
        $this->advert->bills = null;
        $this->assertEquals(0, $this->advert->bills_translated);

        $this->advert->bills = 200;
        $this->assertEquals(200, $this->advert->bills_translated);
    }

    /** @test */
    public function it_will_fetch_deposit_attribute_as_integer()
    {
        $this->advert->deposit = null;
        $this->assertEquals('0', $this->advert->deposit_translated);

        $this->advert->deposit = 200;
        $this->assertEquals(200, $this->advert->deposit_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_room_size_attribute()
    {
        $this->advert->room_size = 'single';
        $this->assertEquals('jednoosobowy', $this->advert->room_size_translated);

        $this->advert->room_size = 'double';
        $this->assertEquals('dwuosobowy', $this->advert->room_size_translated);

        $this->advert->room_size = 'triple';
        $this->assertEquals('trzyosobowy i więcej', $this->advert->room_size_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_available_from_attribute()
    {
        $now = now();

        $this->advert->available_from = $now;
        $this->assertEquals('od zaraz', $this->advert->available_from_translated);

        $this->advert->available_from = $now->addDay();
        $this->assertEquals($now->format('Y-m-d'), $this->advert->available_from_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_minimum_stay_attribute()
    {
        $this->advert->minimum_stay = null;

        $this->assertEquals('brak preferencji', $this->advert->minimum_stay_translated);

        $this->advert->minimum_stay = 1;
        $this->assertEquals('1 miesiąc', $this->advert->minimum_stay_translated);

        $this->advert->minimum_stay = 18;
        $this->assertEquals('18 miesięcy', $this->advert->minimum_stay_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_maximum_stay_attribute()
    {
        $this->advert->maximum_stay = null;
        $this->assertEquals('brak preferencji', $this->advert->maximum_stay_translated);

        $this->advert->maximum_stay = 1;
        $this->assertEquals('1 miesiąc', $this->advert->maximum_stay_translated);

        $this->advert->maximum_stay = 18;
        $this->assertEquals('18 miesięcy', $this->advert->maximum_stay_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_furnished_attribute()
    {
        $this->advert->furnished = true;

        $this->assertEquals('tak', $this->advert->furnished_translated);

        $this->advert->furnished = false;

        $this->assertEquals('nie', $this->advert->furnished_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_living_room_attribute()
    {
        $this->advert->living_room = true;
        $this->assertEquals('tak', $this->advert->living_room_translated);

        $this->advert->living_room = false;
        $this->assertEquals('nie', $this->advert->living_room_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_garden_attribute()
    {
        $this->advert->garden = true;
        $this->assertEquals('tak', $this->advert->garden_translated);

        $this->advert->garden = false;
        $this->assertEquals('nie', $this->advert->garden_translated);
    }
    
    /** @test */
    public function it_returns_string_representation_of_broadband_attribute()
    {
        $this->advert->broadband = true;
        $this->assertEquals('tak', $this->advert->broadband_translated);

        $this->advert->broadband = false;
        $this->assertEquals('nie', $this->advert->broadband_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_parking_attribute()
    {
        $this->advert->parking = true;
        $this->assertEquals('tak', $this->advert->parking_translated);

        $this->advert->parking = false;
        $this->assertEquals('nie', $this->advert->parking_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_garage_attribute()
    {
        $this->advert->garage = true;
        $this->assertEquals('tak', $this->advert->garage_translated);

        $this->advert->garage = false;
        $this->assertEquals('nie', $this->advert->garage_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_gender_attribute()
    {
        $this->advert->gender = null;
        $this->assertEquals('brak preferencji', $this->advert->gender_translated);

        $this->advert->gender = 'f';
        $this->assertEquals('kobieta', $this->advert->gender_translated);

        $this->advert->gender = 'm';
        $this->assertEquals('męszczyzna', $this->advert->gender_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_occupation_attribute()
    {
        $this->advert->occupation = null;
        $this->assertEquals('brak preferencji', $this->advert->occupation_translated);

        $this->advert->occupation = 'student';
        $this->assertEquals('student', $this->advert->occupation_translated);

        $this->advert->occupation = 'professional';
        $this->assertEquals('pracujący', $this->advert->occupation_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_minimum_age_attribute()
    {
        $this->advert->minimum_age = null;
        $this->assertEquals('brak preferencji', $this->advert->minimum_age_translated);

        $this->advert->minimum_age = 18;
        $this->assertEquals(18, $this->advert->minimum_age_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_maximum_age_attribute()
    {
        $this->advert->maximum_age = null;
        $this->assertEquals('brak preferencji', $this->advert->maximum_age_translated);

        $this->advert->maximum_age = 18;
        $this->assertEquals(18, $this->advert->maximum_age_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_nonsmoking_attribute()
    {
        $this->advert->nonsmoking = false;
        $this->assertEquals('tak', $this->advert->nonsmoking_translated);

        $this->advert->nonsmoking = true;
        $this->assertEquals('nie', $this->advert->nonsmoking_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_couples_attribute()
    {
        $this->advert->couples = false;
        $this->assertEquals('nie', $this->advert->couples_translated);

        $this->advert->couples = true;
        $this->assertEquals('tak', $this->advert->couples_translated);
    }

    /** @test */
    public function it_returns_string_representation_of_pets_attribute()
    {
        $this->advert->pets = false;
        $this->assertEquals('nie', $this->advert->pets_translated);

        $this->advert->pets = true;
        $this->assertEquals('tak', $this->advert->pets_translated);
    }
}
