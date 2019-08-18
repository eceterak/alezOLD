<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;

class FilterAdvertsTest extends TestCase
{
    use RefreshDatabase;
        
    /** @test */
    public function admin_can_filter_adverts_by_verification_status()
    {
        $this->signInAdmin();

        $verifiedAdvert = AdvertFactory::create([
            'verified' => true
        ]);

        $unVerifiedAdvert = AdvertFactory::create([
            'verified' => false
        ]);

        $this->get(route('admin.adverts', ['verified' => 'n']))
            ->assertSee($unVerifiedAdvert->title)
            ->assertDontSee($verifiedAdvert->title);

        $this->get(route('admin.adverts', ['verified' => 'y']))
            ->assertSee($verifiedAdvert->title)
            ->assertDontSee($unVerifiedAdvert->title);
    }

    /** @test */
    public function admin_can_filter_adverts_by_revision_status()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $advert = AdvertFactory::create([
            'revision' => null
        ]);

        $advertWithRevision = AdvertFactory::create([
            'revision' => [
                'title' => 'asd'
            ]
        ]);

        $this->get(route('admin.adverts', ['revised' => 'y']))
            ->assertSee($advert->title)
            ->assertDontSee($advertWithRevision->title);

        $this->get(route('admin.adverts', ['revised' => 'n']))
            ->assertSee($advertWithRevision->title)
            ->assertDontSee($advert->title);
    }

    /** @test */
    public function admin_can_filter_adverts_by_archivision_status()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $advert = AdvertFactory::create([
            'archived' => false
        ]);

        $archivedAdvert = AdvertFactory::create([
            'archived' => true
        ]);

        $this->get(route('admin.adverts', ['archived' => 'y']))
            ->assertSee($archivedAdvert->title)
            ->assertDontSee($advert->title);

        $this->get(route('admin.adverts', ['archived' => 'n']))
            ->assertSee($advert->title)
            ->assertDontSee($archivedAdvert->title);
    }
}
