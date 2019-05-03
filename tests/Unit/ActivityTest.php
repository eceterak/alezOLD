<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\RoomFactory;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_it_has_a_user()
    {
        $room = RoomFactory::ownedBy($this->user())->create();

        $this->assertEquals(auth()->user()->id, $room->activities->first()->user->id);
    }
}
