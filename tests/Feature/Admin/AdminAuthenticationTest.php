<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\CityFactory;
use Facades\Tests\Setup\RoomFactory;
use Facades\Tests\Setup\StreetFactory;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_unauthorized_user_cannot_delete_cities()
    {
        $city = CityFactory::create();

        $this->delete(route('admin.cities.destroy', $city->id))->assertRedirect(route('admin.login'));

        $this->user();

        $this->delete(route('admin.cities.destroy', $city->id))->assertRedirect(route('index'));
    }

    // @test
    public function test_guests_cannot_manage_cities() 
    {
        $city = CityFactory::create();

        $this->get(route('admin.cities'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.cities.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.edit', [$city->slug]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.cities.update', [$city->slug]), [])->assertRedirect(route('admin.login'));

        $this->user();

        $this->get(route('admin.cities'))->assertRedirect(route('index'));
        $this->get(route('admin.cities.create'))->assertRedirect(route('index'));
        $this->post(route('admin.cities.store'), [])->assertRedirect(route('index'));
        $this->get(route('admin.cities.edit', [$city->slug]))->assertRedirect(route('index'));
        $this->patch(route('admin.cities.update', [$city->slug]), [])->assertRedirect(route('index'));
    }

    // @test
    public function test_guests_cannot_manage_rooms() 
    {
        $room = RoomFactory::create();

        $this->get(route('admin.rooms'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.rooms.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.rooms.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.rooms.edit', [$room->slug]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.rooms.update', [$room->slug]), [])->assertRedirect(route('admin.login'));
    }

    // @test
    public function test_unauthorized_cannot_delete_rooms()
    {
        $room = RoomFactory::create();

        $this->delete(route('admin.rooms.destroy', $room->id))->assertRedirect(route('admin.login'));

        $this->user();

        $this->delete(route('admin.rooms.destroy', $room->id))->assertRedirect(route('index'));
    }

    // @test
    public function test_unauthorized_cannot_delete_streets()
    {
        $street = StreetFactory::create();

        $this->delete(route('admin.streets.destroy', [$street->city->slug, $street->id]))->assertRedirect(route('admin.login'));

        $this->user();

        $this->delete(route('admin.streets.destroy', [$street->city->slug, $street->id]))->assertRedirect(route('index'));
    }

}
