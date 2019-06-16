<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\City;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function search_by_id_of_selected_item_from_autocomplete_list()
    {        
        $city = create(City::class);

        $this->get(route('search.index', [
            'city' => 'ignore this value',
            'city_id' => $city->id
        ]))->assertRedirect(route('cities.show', [$city->slug]));
    }

    /** @test */
    public function search_by_query() 
    {
        $city = create(City::class);

        $this->get(route('search.index', [
            'city' => $city->name,
            'city_id' => ''
        ]))->assertRedirect(route('cities.show', [$city->slug]));
    }

    /** @test */
    public function search_by_query_with_commas() 
    {
        $city = create(City::class);

        $this->get(route('search.index', [
            'city' => $city->name.','.$city->community.','.$city->state,
            'city_id' => ''
        ]))->assertRedirect(route('cities.show', [$city->slug]));
    }
    
    /** @test */
    public function if_no_city_is_found_display_all_available_adverts()
    {
        $this->withoutExceptionHandling();

        $advert = AdvertFactory::create();    

        $this->get(route('search.index', [
            'city' => '',
            'city_id' => 'You wont be able to find this city because it doesent exists.'
        ]))->assertRedirect(route('adverts'));
    }
    
    /** @test */
    public function ajax_autocomplete_suggestions() 
    {
        $city = create(City::class, ['name' => 'Krakow']);
        $city = create(City::class, ['name' => 'Krakowiany']);

        $results = $this->json('GET', action('AjaxController@cities'), ['city' => substr($city->name, 0, 3)]);

        $this->assertCount(2, $results->json());
    }
    
    /** @test */
    public function empty_search_query_redirect_to_adverts_index()
    {
        $this->get(route('search.index'), [
            'city' => '',
            'city_id' => ''
        ])->assertRedirect(route('adverts'));
    }
    
}
