<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\City;
use Facades\Tests\Setup\AdvertFactory;
use App\CitySubscription;

class CitySubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_subscribe_to_city()
    {
        $user = $this->signIn();

        $city = create(City::class);

        $this->post(route('city.subscribe', $city->slug));

        $this->assertCount(1, $city->subscriptions);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_city()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $city = create(City::class);

        $city->subscribe();

        $this->delete(route('city.unsubscribe', $city->slug));

        $this->assertCount(0, $city->subscriptions);
    }
}
