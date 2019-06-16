<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Inspections\Spam;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_for_invalid_keywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Nice and clean'));
    }

    /** @test */
    public function it_checks_for_any_key_beign_hold()
    {
        $spam = new Spam();

        $this->expectException('Exception');

        $this->assertFalse($spam->detect('aaaaaa'));
    }
}
