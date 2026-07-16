<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'concentration',
        'size_ml',
        'top_notes',
        'heart_notes',
        'base_notes',
        'featured',
        'price_cents',
        'image',
        'stock',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    public function getPriceAttribute(): float
    {
        return $this->price_cents / 100;
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'men' => "Men's",
            'women' => "Women's",
            default => 'Unisex',
        };
    }

    /**
     * Looks for /public/images/products/{slug}.{jpg|jpeg|png|webp} and returns
     * its public URL if found. Drop a photo in that folder named after the
     * product's slug and it will be picked up automatically — no database
     * changes needed.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $extension) {
            $relativePath = "images/products/{$this->slug}.{$extension}";

            if (file_exists(public_path($relativePath))) {
                return asset($relativePath);
            }
        }

        return null;
    }
}
