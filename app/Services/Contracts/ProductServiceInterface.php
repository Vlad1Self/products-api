<?php

namespace App\Services\Contracts;

use App\DTOs\ProductFilterDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function filterProducts(ProductFilterDTO $data): LengthAwarePaginator;
}
