<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\RoomFactory;
use Facades\Tests\Setup\CityFactory;

class SearchTest extends TestCase
{

    use RefreshDatabase;

    // @test
    public function test_search_by_id_of_selected_item_from_autocomplete_list()
    {        
        $room = RoomFactory::create();

        $this->get(route('search.index', [
            'city' => 'ignore this value',
            'city_id' => $room->city->id
        ]))
        ->assertRedirect(route('cities.show', [$room->city->slug]));
    }

    // @test
    public function test_search_by_query() 
    {
        $this->withoutExceptionHandling();

        $room = RoomFactory::create();

        $this->get(route('search.index', [
            'city' => $room->city->name,
            'city_id' => ''
        ]))
        ->assertRedirect(route('cities.show', [$room->city->slug]));
    }
    
    // @test
    public function test_ajax_autocomplete_suggestions() 
    {
        $city = CityFactory::create();
        
        $this->post(route('ajax.cities'), [
            'city' => substr($city->name, 0, 3)
        ])
        ->assertSee($city->name);
    }
    
    //@test
    public function test_empty_search_query_redirect_to_rooms_index()
    {
        $this->get(route('search.index'), [
            'city' => '',
            'city_id' => ''
        ])
        ->assertRedirect(route('rooms'));
    }
    
}
