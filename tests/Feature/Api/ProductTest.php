<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Product::query()->delete();
        Category::query()->delete();

        Category::factory()->create(['name' => 'Electronics']);
        Category::factory()->create(['name' => 'Books']);
    }

    public function test_can_list_products(): void
    {
        Product::factory(15)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'name',
                            'price',
                            'category',
                            'in_stock',
                            'rating',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                    'timestamp'
                ],
                'meta' => [
                    'total',
                    'count',
                    'per_page',
                    'current_page',
                    'total_pages'
                ],
                'status' => ['code', 'message', 'description']
            ]);

        $this->assertCount(10, $response->json('data.items'));
        $this->assertEquals(15, $response->json('meta.total'));
    }

    public function test_can_filter_by_query(): void
    {
        Product::factory()->create(['name' => 'Apple iPhone 15']);
        Product::factory()->create(['name' => 'Samsung Galaxy S23']);

        $response = $this->getJson('/api/products?q=iPhone');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data.items'));
        $this->assertEquals('Apple iPhone 15', $response->json('data.items.0.name'));
    }

    public function test_can_filter_by_price_range(): void
    {
        Product::factory()->create(['price' => 100]);
        Product::factory()->create(['price' => 500]);
        Product::factory()->create(['price' => 1000]);

        $response = $this->getJson('/api/products?price_from=200&price_to=600');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data.items'));
        $this->assertEquals(500, $response->json('data.items.0.price'));
    }

    public function test_can_filter_by_category(): void
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $books = Category::where('name', 'Books')->first();

        Product::factory()->create(['category_id' => $electronics->id]);
        Product::factory()->create(['category_id' => $books->id]);

        $response = $this->getJson("/api/products?category_id={$electronics->id}");

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data.items'));
        $this->assertEquals($electronics->id, $response->json('data.items.0.category.id'));
    }

    public function test_can_filter_by_stock_status(): void
    {
        Product::factory()->create(['in_stock' => true]);
        Product::factory()->create(['in_stock' => false]);

        $response = $this->getJson('/api/products?in_stock=true');
        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data.items'));
        $this->assertTrue($response->json('data.items.0.in_stock'));

        $response = $this->getJson('/api/products?in_stock=false');
        $this->assertCount(1, $response->json('data.items'));
        $this->assertFalse($response->json('data.items.0.in_stock'));
    }

    public function test_can_filter_by_rating(): void
    {
        Product::factory()->create(['rating' => 2.5]);
        Product::factory()->create(['rating' => 4.5]);

        $response = $this->getJson('/api/products?rating_from=4');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data.items'));
        $this->assertEquals(4.5, $response->json('data.items.0.rating'));
    }

    public function test_can_sort_products(): void
    {
        Product::factory()->create(['price' => 1000, 'rating' => 3.0, 'created_at' => now()->subDay()]);
        Product::factory()->create(['price' => 500, 'rating' => 5.0, 'created_at' => now()]);

        $response = $this->getJson('/api/products?sort=price_asc');
        $this->assertEquals(500, $response->json('data.items.0.price'));

        $response = $this->getJson('/api/products?sort=price_desc');
        $this->assertEquals(1000, $response->json('data.items.0.price'));

        $response = $this->getJson('/api/products?sort=rating_desc');
        $this->assertEquals(5.0, $response->json('data.items.0.rating'));

        $response = $this->getJson('/api/products?sort=newest');
        $this->assertEquals(Product::orderByDesc('created_at')->first()->id, $response->json('data.items.0.id'));
    }

    public function test_validation_errors(): void
    {
        $response = $this->getJson('/api/products?sort=invalid_sort&rating_from=6');

        $response->assertStatus(422)
            ->assertJson([
                'status' => [
                    'code' => 422,
                    'message' => 'Ошибка валидации'
                ]
            ]);
    }
}
