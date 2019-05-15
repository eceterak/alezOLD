<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;
use App\Street;

class StreetTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function street_requires_a_name()
    {
        $this->signInAdmin();

        $city = create(City::class);

        $street = raw(City::class, [
            'name' => ''
        ]);

        $this->post(route('admin.streets.store', $city->slug), $street)->assertSessionHasErrors('name');
    }

    /** @test */
    public function street_requires_latitude_and_longtitude()
    {
        $this->signInAdmin();

        $city = create(City::class);

        $street = raw(City::class, [
            'lon' => '',
            'lat' => ''
        ]);

        $this->post(route('admin.streets.store', $city->slug), $street)->assertSessionHasErrors(['lat', 'lon']);
    }

    /** @test */
    public function street_belongs_to_a_city()
    {
        $street = create(Street::class);        

        $this->assertInstanceOf('App\City', $street->city);
    }

}
