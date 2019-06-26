<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\Advert;
use App\Street;
use App\Photo;

class AdvertsManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_an_advert()
    {
        $this->signInAdmin();

        $street = create(Street::class);

        $this->get(action('Admin\AdvertsController@create'))->assertStatus(200);

        $this->post(route('admin.adverts.store', $attributes = raw(Advert::class, [
            'city_id' => $street->city->id,
            'street_id' => $street->id
        ])))->assertRedirect(route('admin.adverts'));

        $advert = Advert::where('title', $attributes['title'])->first();

        $this->get(route('admin.adverts'))->assertSee($advert->title);
    }

    /** @test */
    public function advert_can_be_verified()
    {
        $this->signInAdmin();

        $advert = AdvertFactory::create([
            'verified' => false
        ]);

        $this->json('POST', route('admin.adverts.verify', $advert->slug))->assertStatus(200);

        $this->assertTrue($advert->fresh()->verified);
    }

    /** @test */
    public function when_advert_is_verified_its_photos_are_verified_as_well()
    {    
        $this->signInAdmin();

        $advert = AdvertFactory::create([
            'verified' => false
        ]);

        create(Photo::class, [
            'advert_id' => $advert->id,
            'order' => 0,
            'verified' => false
        ], 3);

        $this->json('POST', route('admin.adverts.verify', $advert->slug))->assertStatus(200);

        $advert->photos->each(function($photo) 
        {
            $this->assertTrue($photo->verified);
        });
    }

    /** @test */
    public function admin_can_accept_pending_revision()
    {
        $this->signInAdmin();

        $attributes = [
            "title" => "some dummy title",
            "description" => "description has been updated",
            "rent" => 2000,
            "pets" => 1
        ];
        
        $advert = AdvertFactory::create([
            'revision' => $attributes
        ]);

        $this->post(route('admin.adverts.revision.store', $advert->slug))->assertRedirect(route('admin.adverts.edit', $advert->fresh()->slug));

        tap($advert->fresh(), function($advert) use ($attributes)
        {
            $this->assertEquals($advert->only('title', 'description', 'rent', 'pets'), $attributes);

            $this->assertNull($advert->revision);
        });
    }

    /** @test */
    public function admin_can_accept_reject_pending_revision()
    {
        $this->signInAdmin();

        $attributes = [
            "title" => "some dummy title",
            "description" => "description has been updated",
            "rent" => 2000,
            "pets" => 1
        ];
        
        $advert = AdvertFactory::create([
            'revision' => $attributes
        ]);

        $this->delete(route('admin.adverts.revision.destroy', $advert->slug))->assertRedirect(route('admin.adverts.edit', $advert->fresh()->slug));

        tap($advert->fresh(), function($advert) use ($attributes)
        {
            $this->assertNotEquals($advert->only('title', 'description', 'rent', 'pets'), $attributes);

            $this->assertNull($advert->revision);
        });
    }

    /** @test */
    public function admin_can_update_any_advert() 
    {   
        $this->signInAdmin();

        $advert = AdvertFactory::create([
            'verified' => false
        ]);

        $this->get(route('admin.adverts.edit', $advert->slug))->assertSee($advert->title);

        $this->patch(route('admin.adverts.update', [$advert->slug]), $attributes = raw(Advert::class, [
            'city_id' => $advert->city->id,
            'street_id' => $advert->street->id,
            'title' => 'some dummy title',
            'verified' => false
        ]))->assertRedirect(route('admin.adverts'));

        $this->assertEquals($attributes['title'], $advert->fresh()->title);
    }

    /** @test */
    public function admin_can_delete_any_advert()
    {
        $this->signInAdmin();

        $advert = AdvertFactory::create();

        $this->delete(route('admin.adverts.destroy', $advert->slug))->assertRedirect(route('admin.adverts'));

        $this->assertTrue($advert->fresh()->archived);
    }
}
