<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\Api\ProductCollection;
use App\Services\Contracts\ProductServiceInterface;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $productService
    ) {}

    public function index(ProductFilterRequest $request): JsonResponse
    {
        $products = $this->productService->filterProducts(
            $request->getDTO()
        );

        $collection = new ProductCollection($products);

        return ApiResponse::success($collection, $collection->getPagination());
    }
}
