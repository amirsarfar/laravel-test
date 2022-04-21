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

    public function test_products_index_method()
    {
        Product::factory()->count(25)->create();

        $headers = ['Accept' => 'application/json'];

        $response = $this->json('GET', '/api/v1/products', [], $headers)
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

    public function test_products_show_method()
    {
        Product::factory()->count(5)->create();

        $headers = ['Accept' => 'application/json'];

        $response = $this->json('GET', '/api/v1/products/4', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'description', 'title', 'price', 'created_at', 'updated_at'],
            ]);

        $response = $this->json('GET', '/api/v1/products/17', [], $headers)
            ->assertStatus(404)
            ->assertJson([
                'error' => 'Resource not found',
            ]);
    }

    public function test_products_store_method()
    {
        $headers = ['Accept' => 'application/json'];
        $payload = [
            'title' => 'Product1',
            'description' => 'Desc1 ten characters long',
            'price' => 250000,
        ];

        $this->json('POST', '/api/v1/products', $payload, $headers)
            ->assertStatus(201)
            ->assertJson(['id' => 1, 'title' => 'Product1', 'description' => 'Desc1 ten characters long', 'price' => 250000]);
    }

    public function test_products_update_method()
    {
        Product::factory()->count(1)->create();

        $headers = ['Accept' => 'application/json'];
        $payload = [
            'title' => 'Product1 edited',
        ];

        $this->json('PUT', '/api/v1/products/1', $payload, $headers)
            ->assertStatus(200)
            ->assertJson(['id' => 1, 'title' => 'Product1 edited']);
    }

    public function test_products_delete_method()
    {
        Product::factory()->count(1)->create();

        $headers = ['Accept' => 'application/json'];

        $this->json('DELETE', '/api/v1/products/1', [], $headers)
            ->assertStatus(204);
    }
}
