<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\Advert;

class ManageAdvertTest extends TestCase
{

    protected $advert;

    public function setUp()
    {
        parent::setUp();

        $this->advert = AdvertFactory::create([
            'pets' => false
        ]);
    }

    use RefreshDatabase;

    /** @test */
    public function owner_of_the_advert_can_update_it() 
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->advert->user)->get(route('adverts.edit', [$this->advert->city->slug, $this->advert->slug]));

        $this->patch(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'city_id' => $this->advert->city->id,
            'street_id' => $this->advert->city->id,
            'title' => 'some dummy title',
            'description' => 'description has been updated',
            'rent' => 2000,
            'pets' => 1
        ])->assertRedirect(route('home'));

        $this->assertEquals($this->advert->fresh()->revision, [
            'title' => 'some dummy title',
            'description' => 'description has been updated',
            'rent' => 2000,
            'pets' => 1
        ]);

        $this->actingAs($this->advert->user)
            ->get(route('adverts.edit', [$this->advert->city->slug, $this->advert->slug]))
            ->assertSee('some dummy title');
    }

    /** @test */
    public function changes_are_not_visible_to_the_users_until_advert_is_revised_by_the_admin() 
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->advert->user)->get(route('adverts.edit', [$this->advert->city->slug, $this->advert->slug]));

        $this->patch(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [
            'city_id' => $this->advert->city->id,
            'street_id' => $this->advert->city->id,
            'title' => 'some dummy title',
            'description' => 'description has been updated',
            'rent' => 2000,
            'pets' => 1
        ])->assertRedirect(route('home'));

        tap($this->advert->fresh(), function($advert) 
        {
            $this->assertNotEquals($advert->title, 'some dummy title');

            $advert->acceptRevision();

            $this->assertEquals($advert->title, 'some dummy title');
        });
        
    }

    /** @test */
    public function updating_the_title_also_updates_a_slug() 
    {
        $this->signIn($this->advert->user);

        $this->patch(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), $attributes = raw(Advert::class, [
            'title' => 'The title is updated',
            'city_id' => $this->advert->city->id,
            'street_id' => $this->advert->city->id
        ]));

        $this->advert->fresh()->acceptRevision();

        $this->assertEquals('the-title-is-updated', $this->advert->fresh()->slug);
    }

    /** @test */
    public function user_cannot_update_adverts_of_others() 
    {
        $this->withoutExceptionHandling(); // Do not remove.

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->actingAs($this->user())->get(route('adverts.edit', [$this->advert->city->slug, $this->advert->slug]));
        
        $this->patch(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [])->assertStatus(403);
    }

    /** @test */
    public function owner_of_the_advert_can_delete_it()
    {
        $this->actingAs($this->advert->user)->delete(route('adverts.destroy', [$this->advert->city->slug, $this->advert->slug]))->assertRedirect();

        $this->assertTrue($this->advert->fresh()->archived);

        $this->get(route('adverts.show', [$this->advert->city->slug, $this->advert->slug]))->assertSeeText('Ogłoszenie zakończone.');
    }

    /** @test */
    public function guests_cannot_delete_adverts()
    {
        $this->delete(route('adverts.destroy', [$this->advert->city->slug, $this->advert->slug]))->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_cannot_delete_adverts_of_others()
    {
        $this->actingAs($this->user())->delete(route('adverts.destroy', [$this->advert->city->slug, $this->advert->slug]))->assertStatus(403);
    }
}
