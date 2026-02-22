<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'disk',
        'path',
        'original_filename',
        'mime_type',
        'size',
        'variants',
        'order',
        'is_primary',
    ];

    protected $casts = [
        'variants' => 'array',
        'is_primary' => 'boolean',
        'order' => 'integer',
        'size' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the CDN URL for a specific variant (or the original).
     */
    public function url(?string $variant = 'medium'): ?string
    {
        if (! $this->disk) {
            return null;
        }

        $path = $variant && isset($this->variants[$variant])
            ? $this->variants[$variant]
            : $this->path;

        if (! $path) {
            return null;
        }

        $diskConfig = config("filesystems.disks.{$this->disk}");
        if (! empty($diskConfig['url'])) {
            return rtrim($diskConfig['url'], '/') . '/' . ltrim($path, '/');
        }

        return Storage::disk($this->disk)->url($path);
    }

    /**
     * Build a responsive srcset string from all variants.
     */
    public function srcset(): ?string
    {
        if (! $this->variants || ! $this->disk) {
            return null;
        }

        $variantConfig = config('media.variants');
        $parts = [];

        foreach ($this->variants as $name => $path) {
            if (isset($variantConfig[$name])) {
                $url = $this->url($name);
                $width = $variantConfig[$name]['width'];
                $parts[] = "{$url} {$width}w";
            }
        }

        return implode(', ', $parts) ?: null;
    }
}
