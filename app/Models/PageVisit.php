<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVisit extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'url',
        'product_id',
        'referrer',
        'device',
        'user_agent',
        'ip',
        'status_code',
        'is_bot',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'is_bot' => 'boolean',
        'status_code' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeHuman(Builder $query): Builder
    {
        return $query->where('is_bot', false);
    }

    public function scopeNotFound(Builder $query): Builder
    {
        return $query->where('status_code', 404);
    }

    public function scopeProductViews(Builder $query): Builder
    {
        return $query->whereNotNull('product_id');
    }
}
