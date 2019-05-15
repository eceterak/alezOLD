<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\TemporaryAdvert;
use App\Advert;
use App\Street;

class CreateAdvertTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function visiting_create_new_advert_page_generates_a_temporary_advert()
    {
        $this->actingAs($this->user())->get(route('adverts.create'));

        $this->assertCount(1, TemporaryAdvert::all());
    }

    /** @test */
    public function user_can_create_an_advert()
    {   
        $this->actingAs($this->user())->get(route('adverts.create'))->assertStatus(200);

        $street = create(Street::class);

        $temporary = TemporaryAdvert::first();
        
        $this->post(route('adverts.store'), $attributes = raw(Advert::class, [
            'temp' => $temporary->id,
            'token' => $temporary->token,
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ]))
        ->assertRedirect(route('home'));

        Advert::where('title', $attributes['title'])->first();
                
        $this->assertEmpty(TemporaryAdvert::all());
    }

    /** @test */
    public function guest_cannot_see_create_advert_page()
    {
        $this->get(route('adverts.create'))->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_create_advert()
    {
        $this->post(route('adverts.store'))->assertRedirect(route('login'));
    }

}
