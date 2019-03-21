<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Advert;

class AdvertsManagementTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * Admin can create an advert.
     * 
     * @return test
     */
    public function test_admin_can_create_an_advert()
    {
        $this->withoutExceptionHandling();

        $this->authenticated(null, true);

        $this->get(route('admin.adverts.create'))->assertStatus(200);

        $advert = factory(Advert::class)->raw(['user_id' => auth()->user()->id]);

        $this->post(route('admin.adverts.store', $advert))->assertRedirect(route('admin.adverts'));

        $this->assertDatabaseHas('adverts', $advert);

        $this->get(route('admin.adverts'))->assertSee($advert['title']);
    }

    /**
     * Admin have permissions to edit an advert.
     * 
     * @return
     */
    public function test_admin_can_edit_any_advert() 
    {
        $this->withoutExceptionHandling();
        
        $this->authenticated(null, true);

        $advert = factory(Advert::class)->create();
        
        $this->get(route('admin.adverts.edit', [$advert->city->name, $advert->title]))->assertSee($advert->title);
    }


}
