<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    private static array $products = [
        ['iPhone 15 Pro', 129999, 4.8, true],
        ['iPhone 15 Pro Max', 149999, 4.9, true],
        ['Samsung Galaxy S24', 99999, 4.6, true],
        ['Samsung Galaxy S24+', 119999, 4.7, true],
        ['Google Pixel 8', 79999, 4.5, false],
        ['Google Pixel 8 Pro', 139999, 4.6, false],
        ['MacBook Pro 14', 219999, 4.9, true],
        ['MacBook Pro 16', 249999, 4.9, true],
        ['Apple MacBook Air', 139999, 4.6, false],
        ['Apple MacBook Pro', 249999, 4.9, true],
        ['Dell XPS 13', 159999, 4.7, true],
        ['Dell XPS 15', 199999, 4.7, true],
        ['Dell Inspiron', 119999, 4.7, true],
        ['HP Pavilion', 129999, 4.8, true],
        ['HP Envy', 149999, 4.6, true],
        ['PlayStation 5', 69999, 4.9, false],
        ['PlayStation 5 Pro', 79999, 4.9, false],
        ['Xbox Series X', 64999, 4.8, true],
        ['Xbox Series S', 54999, 4.8, true],
        ['Nintendo Switch', 34999, 4.7, true],
        ['Apple Watch Series 9', 39999, 4.8, true],
        ['Samsung Galaxy Watch 6', 34999, 4.7, true],
        ['Bose QuietComfort 45', 29999, 4.9, true],
        ['Sony WH-1000XM5', 27999, 4.8, true],
        ['Kindle Paperwhite', 14999, 4.6, true],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $item = self::$products[self::$index % count(self::$products)];
        self::$index++;

        $category = Category::inRandomOrder()->first();

        return [
            'name' => $item[0],
            'price' => $item[1],
            'rating' => $item[2],
            'in_stock' => $item[3],
            'category_id' => $category ? $category->id : null,
        ];
    }
}
