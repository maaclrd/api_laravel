<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function test_can_list_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products', $this->authenticate());

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_can_create_product()
    {
        $data = [
            'name' => 'Produto Teste',
            'description' => 'Descrição',
            'price' => 99.99,
            'stock' => 10
        ];

        $response = $this->postJson('/api/products', $data, $this->authenticate());

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'Produto Teste');
    }

    public function test_can_show_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}", $this->authenticate());

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $product->id);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();

        $data = [
            'name' => 'Produto Atualizado',
            'price' => 79.99
        ];

        $response = $this->putJson("/api/products/{$product->id}", $data, $this->authenticate());

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Produto Atualizado');
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}", [], $this->authenticate());

        $response->assertStatus(204);
    }
}