<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'min_variant_price',
    ];

    protected $casts = [
        'min_variant_price' => 'decimal:2',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        return $this->primaryImage?->image_url ?? $this->images->first()?->image_url;
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
