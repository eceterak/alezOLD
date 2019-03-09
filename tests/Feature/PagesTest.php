<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesController extends TestCase
{

    public function test_check_if_pages_load()
    {
        $this->withoutExceptionHandling();

        $this->get('/')->assertStatus(200);
    }
}
