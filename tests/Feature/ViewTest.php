<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testHomeView()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testAddView()
    {
        $response = $this->get('/product/add');

        $response->assertStatus(200);
    }

    public function testDeleteView()
    {
        $response = $this->get('/product/remove');

        $response->assertStatus(200);
    }
}
