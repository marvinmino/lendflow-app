<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BestSellerTest extends TestCase
{
    public function test_best_sellers_endpoint_returns_data()
    {
        $response = $this->getJson('/api/v1/bestsellers?cache=false');
    
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'timestamp',
                     'cache',
                     'data' => [
                         '*' => ['author', 'isbn', 'title', 'offset']
                     ]
                 ]);
    }
    
}
