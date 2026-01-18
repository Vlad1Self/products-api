<?php

namespace App\Services;

use App\Models\Product;
use App\DTOs\ProductFilterDTO;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface
{
    public function filterProducts(ProductFilterDTO $data): LengthAwarePaginator
    {
        return Product::query()
            ->with('category')
            ->search($data->q)
            ->priceFrom($data->price_from)
            ->priceTo($data->price_to)
            ->category($data->category_id)
            ->inStock($data->in_stock)
            ->ratingFrom($data->rating_from)
            ->sort($data->sort)
            ->paginate(10, ['*'], 'page', $data->page);
    }
}
