<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    private static array $categories = [
        'Смартфоны',
        'Ноутбуки',
        'Аксессуары',
        'Бытовая техника',
        'Игровые консоли',
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $name = self::$categories[self::$index % count(self::$categories)];
        self::$index++;

        return [
            'name' => $name,
        ];
    }
}
