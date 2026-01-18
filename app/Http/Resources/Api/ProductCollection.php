<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\Api\ProductResource;

class ProductCollection extends ResourceCollection
{
    public $collects = ProductResource::class;

    public function toArray(Request $request): array
    {
        return [
            'items' => $this->collection,
            'timestamp' => now()->toDateTimeString(),
        ];
    }

    public function getPagination(): array
    {
        if ($this->resource instanceof LengthAwarePaginator) {
            return [
                'total' => $this->resource->total(),
                'count' => $this->resource->count(),
                'per_page' => $this->resource->perPage(),
                'current_page' => $this->resource->currentPage(),
                'total_pages' => $this->resource->lastPage(),
            ];
        }

        return [];
    }
}
