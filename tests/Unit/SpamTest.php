<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Inspections\Spam;

class SpamTest extends TestCase
{
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
