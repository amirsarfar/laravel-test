<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductsEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_list()
    {
        Product::factory()->count(25)->create();

        $response = $this->json('GET', '/api/v1/products')
            ->assertStatus(200)
            ->assertJson([
                'total' => 25,
                'last_page' => 3
            ])
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'description', 'title', 'price', 'created_at', 'updated_at'],
                ],
            ]);
    }
}
