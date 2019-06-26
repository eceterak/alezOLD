<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use App\User;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create(User::class);

        $this->get(route('profiles.show', $user->id))
            ->assertSee($user->fresh()->name);
    }

    /** @test */
    public function profiles_display_all_adverts_created_by_associated_user()
    {
        $user = create(User::class);

        $advert = AdvertFactory::ownedBy($user)->create();

        $this->get(route('profiles.show', $user->id))
            ->assertSee($advert->title);
    }
}
