<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'in_stock',
        'rating',
    ];

    protected $casts = [
        'in_stock' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch(Builder $query, ?string $q): Builder
    {
        return $query->when(
            filled($q),
            fn(Builder $qBuilder) =>
            $qBuilder->where('name', 'LIKE', '%' . trim($q) . '%')
        );
    }

    public function scopePriceFrom(Builder $query, ?float $price): Builder
    {
        return $query->when(
            $price !== null,
            fn($q) =>
            $q->where('price', '>=', $price)
        );
    }

    public function scopePriceTo(Builder $query, ?float $price): Builder
    {
        return $query->when(
            $price !== null,
            fn($q) =>
            $q->where('price', '<=', $price)
        );
    }

    public function scopeCategory(Builder $query, ?int $categoryId): Builder
    {
        return $query->when(
            $categoryId !== null,
            fn($q) =>
            $q->where('category_id', $categoryId)
        );
    }

    public function scopeInStock(Builder $query, ?bool $inStock): Builder
    {
        return $query->when(
            $inStock !== null,
            fn($q) =>
            $q->where('in_stock', $inStock)
        );
    }

    public function scopeRatingFrom(Builder $query, ?float $rating): Builder
    {
        return $query->when(
            $rating !== null,
            fn($q) =>
            $q->where('rating', '>=', $rating)
        );
    }

    public function scopeSort(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'price_asc'   => $query->orderBy('price'),
            'price_desc'  => $query->orderByDesc('price'),
            'rating_desc' => $query->orderByDesc('rating'),
            'newest'      => $query->orderByDesc('created_at'),
            default       => $query->orderBy('id'),
        };
    }
}
