<?php

namespace App\Http\Requests;

use App\DTOs\ProductFilterDTO;
use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('in_stock')) {
            $this->merge([
                'in_stock' => filter_var($this->in_stock, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'q' => 'nullable|string|max:255',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'in_stock' => 'nullable|boolean',
            'rating_from' => 'nullable|numeric|min:0|max:5',
            'sort' => 'nullable|string|in:price_asc,price_desc,rating_desc,newest',
            'page' => 'nullable|integer|min:1',
        ];
    }

    public function getDTO(): ProductFilterDTO
    {
        return ProductFilterDTO::from($this->validated());
    }
}
