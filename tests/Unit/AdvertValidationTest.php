<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;

class AdvertValidationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() 
    {
        parent::setUp();
        
        $this->advert = AdvertFactory::create([
            'created_at' => now()->subDay()
        ]);

        $this->signIn($this->advert->user);
    }

    /** @test */
    public function it_requires_a_title() 
    {
        $this->post(route('adverts.store'))
            ->assertSessionHasErrors('title');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]))
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function it_requires_a_rent() 
    {
        $this->post(route('adverts.store'))
            ->assertSessionHasErrors('rent');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]))
            ->assertSessionHasErrors('rent');
    }

    /** @test */
    public function it_requires_a_city() 
    {    
        $this->post(route('adverts.store'))
            ->assertSessionHasErrors('city_id');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]))
            ->assertSessionHasErrors('city_id');
    }

    /** @test */
    public function it_requires_a_description() 
    {
        $this->post(route('adverts.store'))
            ->assertSessionHasErrors('description');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]))
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_requires_a_room_size() 
    {
        $this->post(route('adverts.store'))
            ->assertSessionHasErrors('room_size');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]))
            ->assertSessionHasErrors('room_size');
    }

    /** @test */
    public function title_must_be_between_3_and_60_characters() 
    {
        $this->post(route('adverts.store'), [
            'title' => 'a'
        ])->assertSessionHasErrors('title');

        $this->post(route('adverts.store'), [
            'title' => 'Totalof51characersormoreTotalof51characersormoreTotalof51characersormore'
        ])->assertSessionHasErrors('title');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'title' => 'a'
        ])->assertSessionHasErrors('title');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'title' => 'Totalof51characersormoreTotalof51characersormoreTotalof51characersormore'
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    public function room_size_must_be_one_of_enum_values() 
    {
        $this->post(route('adverts.store'), [
            'room_size' => 'not good'
        ])->assertSessionHasErrors('room_size');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'room_size' => 'not good'
        ])->assertSessionHasErrors('room_size');
    }
    
    /** @test */
    public function rent_must_be_numeric() 
    {
        $this->post(route('adverts.store'), [
            'rent' => 'asd'
        ])->assertSessionHasErrors('rent');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'rent' => 'not good'
        ])->assertSessionHasErrors('rent');
    }

    /** @test */
    public function valid_city_must_be_provided() 
    {
        $this->post(route('adverts.store'), [
            'city_id' => 9999
        ])->assertSessionHasErrors('city_id');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'city_id' => 213213
        ])->assertSessionHasErrors('city_id');
    }
        
    /** @test */
    public function description_must_be_at_least_50_characters_long() 
    {
        $this->post(route('adverts.store'), [
            'description' => 'a'
        ])->assertSessionHasErrors('description');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'description' => 'not good'
        ])->assertSessionHasErrors('description');
    }

    /** @test */
    public function deposit_must_be_numeric() 
    {
        $this->post(route('adverts.store'), [
            'deposit' => 'asd'
        ])->assertSessionHasErrors('deposit');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'deposit' => 'not good'
        ])->assertSessionHasErrors('deposit');
    }

    /** @test */
    public function bills_must_be_numeric() 
    {
        $this->post(route('adverts.store'), [
            'bills' => 'asd'
        ])->assertSessionHasErrors('bills');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'bills' => 'not good'
        ])->assertSessionHasErrors('bills');
    }

    /** @test */
    public function valid_street_must_be_provided() 
    {    
        $this->post(route('adverts.store'), [
            'street_id' => 9999
        ])->assertSessionHasErrors('street_id');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'street_id' => 1233
        ])->assertSessionHasErrors('street_id');
    }

    /** @test */
    public function phone_must_be_between_9_and_13_digits() 
    {    
        $this->post(route('adverts.store'), [
            'phone' => 9999
        ])->assertSessionHasErrors('phone');

        $this->post(route('adverts.store'), [
            'phone' => 99999999999999
            ])->assertSessionHasErrors('phone');
            
        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'phone' => 99999999999999
        ])->assertSessionHasErrors('phone');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'phone' => 123
        ])->assertSessionHasErrors('phone');
    }

    /** @test */
    public function available_from_must_be_a_valid_date() 
    {    
        $this->post(route('adverts.store'), [
            'available_from' => 'not a date'
        ])->assertSessionHasErrors('available_from');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'available_from' => 123
        ])->assertSessionHasErrors('available_from');
    }

    /** @test */
    public function minimum_stay_must_be_numeric() 
    {    
        $this->post(route('adverts.store'), [
            'minimum_stay' => 'not numeric'
        ])->assertSessionHasErrors('minimum_stay');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'minimum_stay' => 'not a number'
        ])->assertSessionHasErrors('minimum_stay');
    }

    /** @test */
    public function minimum_stay_must_be_between_1_and_36() 
    {    
        $this->post(route('adverts.store'), [
            'minimum_stay' => 99
        ])->assertSessionHasErrors('minimum_stay');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'minimum_stay' => 123
        ])->assertSessionHasErrors('minimum_stay');
    }

    /** @test */
    public function maximum_stay_must_be_numeric() 
    {    
        $this->post(route('adverts.store'), [
            'maximum_stay' => 'not numeric'
        ])->assertSessionHasErrors('maximum_stay');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'maximum_stay' => 'not a number'
        ])->assertSessionHasErrors('maximum_stay');
    }

    /** @test */
    public function maximum_stay_must_be_between_1_and_36() 
    {    
        $this->post(route('adverts.store'), [
            'maximum_stay' => 99
        ])->assertSessionHasErrors('maximum_stay');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'maximum_stay' => 123
        ])->assertSessionHasErrors('maximum_stay');
    }

    /** @test */
    public function landlord_must_be_one_of_enum_values() 
    {
        $this->post(route('adverts.store'), [
            'landlord' => 'not good'
        ])->assertSessionHasErrors('landlord');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'landlord' => 'not good'
        ])->assertSessionHasErrors('landlord');
    }

    /** @test */
    public function property_type_must_be_one_of_enum_values() 
    {
        $this->post(route('adverts.store'), [
            'property_type' => 'invalid value'
        ])->assertSessionHasErrors('property_type');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'property_type' => 'not valid'
        ])->assertSessionHasErrors('property_type');
    }

    /** @test */
    public function property_size_must_be_numeric() 
    {
        $this->post(route('adverts.store'), [
            'property_size' => 'invalid value'
        ])->assertSessionHasErrors('property_size');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'property_size' => '123'
        ])->assertSessionHasErrors('property_size');
    }

    /** @test */
    public function living_room_must_be_a_boolean() 
    {
        $this->post(route('adverts.store'), [
            'living_room' => 2
        ])->assertSessionHasErrors('living_room');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'living_room' => 123
        ])->assertSessionHasErrors('living_room');
    }

    /** @test */
    public function parking_must_be_a_boolean() 
    {
        $this->post(route('adverts.store'), [
            'parking' => 2
        ])->assertSessionHasErrors('parking');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'parking' => 123
        ])->assertSessionHasErrors('parking');
    }

    /** @test */
    public function furnished_must_be_a_boolean() 
    {
        $this->post(route('adverts.store'), [
            'furnished' => 2
        ])->assertSessionHasErrors('furnished');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'furnished' => 123
        ])->assertSessionHasErrors('furnished');
    }

    /** @test */
    public function broadband_must_be_a_boolean() 
    {
        $this->post(route('adverts.store'), [
            'broadband' => 2
        ])->assertSessionHasErrors('broadband');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'broadband' => 123
        ])->assertSessionHasErrors('broadband');
    }

    /** @test */
    public function garage_must_be_a_boolean() 
    {
        $this->post(route('adverts.store'), [
            'garage' => 2
        ])->assertSessionHasErrors('garage');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'garage' => 123
        ])->assertSessionHasErrors('garage');
    }

    /** @test */
    public function garden_must_be_a_boolean() 
    {
        $this->post(route('adverts.store'), [
            'garden' => 2
        ])->assertSessionHasErrors('garden');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'garden' => 123
        ])->assertSessionHasErrors('garden');
    }

    /** @test */
    public function nonsmoking_must_be_a_boolean() 
    {
        $this->post(route('adverts.store'), [
            'nonsmoking' => 'invalid value'
        ])->assertSessionHasErrors('nonsmoking');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'nonsmoking' => 'test 123'
        ])->assertSessionHasErrors('nonsmoking');
    }

    /** @test */
    public function pets_must_be_a_boolean() 
    {
        $this->post(route('adverts.store'), [
            'pets' => 2
        ])->assertSessionHasErrors('pets');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'pets' => 123
        ])->assertSessionHasErrors('pets');
    }

    /** @test */
    public function couples_must_be_a_boolean() 
    {
        $this->post(route('adverts.store'), [
            'couples' => 'some data'
        ])->assertSessionHasErrors('couples');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'couples' => 123
        ])->assertSessionHasErrors('couples');
    }

    /** @test */
    public function occupation_must_be_one_of_enum_values() 
    {
        $this->post(route('adverts.store'), [
            'occupation' => 'invalid value'
        ])->assertSessionHasErrors('occupation');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'occupation' => 123
        ])->assertSessionHasErrors('occupation');
    }

    /** @test */
    public function gender_must_be_one_of_enum_values() 
    {
        $this->post(route('adverts.store'), [
            'gender' => 'invalid value'
        ])->assertSessionHasErrors('gender');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'gender' => 123
        ])->assertSessionHasErrors('gender');
    }

    /** @test */
    public function minimum_age_must_be_numeric() 
    {
        $this->post(route('adverts.store'), [
            'minimum_age' => 'invalid value'
        ])->assertSessionHasErrors('minimum_age');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'minimum_age' => 'not a number'
        ])->assertSessionHasErrors('minimum_age');
    }

    /** @test */
    public function minimum_age_must_be_between_18_and_99() 
    {
        $this->post(route('adverts.store'), [
            'minimum_age' => 1
        ])->assertSessionHasErrors('minimum_age');

        $this->post(route('adverts.store'), [
            'minimum_age' => 100
        ])->assertSessionHasErrors('minimum_age');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'minimum_age' => 1
        ])->assertSessionHasErrors('minimum_age');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'minimum_age' => 100
        ])->assertSessionHasErrors('minimum_age');
    }

    /** @test */
    public function maximum_age_must_be_numeric() 
    {
        $this->post(route('adverts.store'), [
            'maximum_age' => 'invalid value'
        ])->assertSessionHasErrors('maximum_age');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'maximum_age' => 'not a number'
        ])->assertSessionHasErrors('maximum_age');
    }

    /** @test */
    public function maximum_age_must_be_between_18_and_99() 
    {
        $this->post(route('adverts.store'), [
            'maximum_age' => 17
        ])->assertSessionHasErrors('maximum_age');

        $this->post(route('adverts.store'), [
            'maximum_age' => 100
        ])->assertSessionHasErrors('maximum_age');

        $this->post(route('adverts.store'), [
            'maximum_age' => 121
        ])->assertSessionHasErrors('maximum_age');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'maximum_age' => 17
        ])->assertSessionHasErrors('maximum_age');

        $this->post(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'maximum_age' => 100
        ])->assertSessionHasErrors('maximum_age');
    }
}