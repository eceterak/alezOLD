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

        $this->advert = AdvertFactory::create();
    }

    use RefreshDatabase;

    /** @test */
    public function owner_of_the_advert_can_update_it() 
    {
        $this->actingAs($this->advert->user)->get(route('adverts.edit', [$this->advert->city->slug, $this->advert->slug]));

        $this->patch(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), $attributes = raw(Advert::class, [
            'city_id' => $this->advert->city->id,
            'street_id' => $this->advert->city->id,
        ]))->assertRedirect(route('adverts'));

        $this->assertDatabaseHas('adverts', $attributes);
    }

    /** @test */
    public function updating_the_title_also_updates_a_slug() 
    {
        $this->withoutExceptionHandling();

        $this->signIn($this->advert->user);

        $this->patch(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), $attributes = raw(Advert::class, [
            'title' => 'The title is updated',
            'city_id' => $this->advert->city->id,
            'street_id' => $this->advert->city->id
        ]))->assertRedirect(route('adverts'));

        $this->assertEquals('the-title-is-updated', $this->advert->fresh()->slug);
    }

    /** @test */
    public function user_cannot_update_adverts_of_others() 
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->actingAs($this->user())->get(route('adverts.edit', [$this->advert->city->slug, $this->advert->slug]));
        
        $this->patch(route('adverts.update', [$this->advert->city->slug, $this->advert->slug]), [])->assertStatus(403);
    }

    /** @test */
    public function owner_of_the_advert_can_delete_it()
    {
        //$this->signIn($this->advert->user);

        //$response = $this->json('DELETE', route('adverts.destroy', $this->advert->slug));

        $this->actingAs($this->advert->user)->delete(route('adverts.destroy', [$this->advert->city->slug, $this->advert->slug]))->assertRedirect(route('home'));

        $this->assertDatabaseMissing('adverts', $this->advert->only('id'));
    }

    /** @test */
    public function guests_cannot_delete_adverts()
    {
        $this->delete(route('adverts.destroy', [$this->advert->city->slug, $this->advert->slug]))->assertRedirect(route('login'));
    }

    /** @test */
    public function users_cannot_delete_adverts_of_others()
    {
        $this->actingAs($this->user())->delete(route('adverts.destroy', [$this->advert->city->slug, $this->advert->slug]))->assertStatus(403);
    }
}
