<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    private static array $products = [
        ['iPhone 15 Pro', 129999, 4.8, true, 'Смартфоны'],
        ['iPhone 15 Pro Max', 149999, 4.9, true, 'Смартфоны'],
        ['Samsung Galaxy S24', 99999, 4.6, true, 'Смартфоны'],
        ['Samsung Galaxy S24+', 119999, 4.7, true, 'Смартфоны'],
        ['Google Pixel 8 Pro', 139999, 4.6, false, 'Смартфоны'],

        ['MacBook Pro 14', 219999, 4.9, true, 'Ноутбуки'],
        ['MacBook Pro 16', 249999, 4.9, true, 'Ноутбуки'],
        ['Dell XPS 13', 159999, 4.7, true, 'Ноутбуки'],
        ['HP Envy', 149999, 4.6, true, 'Ноутбуки'],

        ['Apple Watch Series 9', 39999, 4.8, true, 'Аксессуары'],
        ['Samsung Galaxy Watch 6', 34999, 4.7, true, 'Аксессуары'],
        ['Sony WH-1000XM5', 27999, 4.8, true, 'Аксессуары'],
        ['Kindle Paperwhite', 14999, 4.6, true, 'Аксессуары'],

        ['PlayStation 5', 69999, 4.9, false, 'Игровые консоли'],
        ['PlayStation 5 Pro', 79999, 4.9, false, 'Игровые консоли'],
        ['Xbox Series X', 64999, 4.8, true, 'Игровые консоли'],
        ['Nintendo Switch', 34999, 4.7, true, 'Игровые консоли'],

        ['Кофемашина DeLonghi', 45999, 4.8, true, 'Бытовая техника'],
        ['Робот-пылесос Xiaomi', 24999, 4.5, true, 'Бытовая техника'],
        ['Микроволновая печь Samsung', 12999, 4.3, true, 'Бытовая техника'],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $item = self::$products[self::$index % count(self::$products)];
        self::$index++;

        $categoryName = $item[4];
        $category = Category::where('name', $categoryName)->first();

        if (!$category) {
            $category = Category::inRandomOrder()->first();
        }

        return [
            'name' => $item[0],
            'price' => $item[1],
            'rating' => $item[2],
            'in_stock' => $item[3],
            'category_id' => $category?->id,
        ];
    }
}
