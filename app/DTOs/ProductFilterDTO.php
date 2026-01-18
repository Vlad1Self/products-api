<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class ProductFilterDTO extends Data
{
    public ?string $q = null;
    public ?float $price_from = null;
    public ?float $price_to = null;
    public ?int $category_id = null;
    public ?bool $in_stock = null;
    public ?float $rating_from = null;
    public ?string $sort = null;
    public ?int $page = 1;
}
