<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesController extends TestCase
{
    use RefreshDatabase;

    /**
     * 
     * 
     * @return
     */
    public function test_authenticated_user_can_login() 
    {
        //$user = 

        //$this->get

        $this->user();

        $this->get(route('home'))->assertOk();
    }
}
