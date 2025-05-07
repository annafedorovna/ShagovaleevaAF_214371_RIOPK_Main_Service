<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeaturesTest extends TestCase
{

    public function testLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testMain()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function testAdmin()
    {
        $response = $this->get('/admin/users');

        $response->assertStatus(302);
    }
}
