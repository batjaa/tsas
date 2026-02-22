<?php

namespace App\Http\Controllers;

use App\Helpers\ColorMap;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __invoke()
    {
        $featuredProducts = Product::with(['images', 'variants'])
            ->where('is_featured', true)
            ->get()
            ->map(function ($product) {
                $colors = $product->variants
                    ->pluck('color')
                    ->unique()
                    ->map(fn ($c) => ColorMap::hex($c))
                    ->values()
                    ->all();

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->variants->first()?->sku ?? '',
                    'image' => $product->primary_image_url,
                    'price' => $product->min_variant_price ?? $product->variants->min('price'),
                    'colors' => $colors,
                    'badge' => $product->badge,
                ];
            });

        $categories = Product::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get()
            ->map(function ($row) {
                $meta = self::categoryMeta($row->category);

                // Get a representative image from a product in this category
                $representativeProduct = Product::where('category', $row->category)
                    ->whereHas('primaryImage')
                    ->first();
                $image = $representativeProduct?->primaryImage?->url('medium');

                return [
                    'title' => $row->category,
                    'subtitle' => $meta['subtitle'],
                    'count' => $row->count,
                    'image' => $image,
                    'icon' => $meta['icon'],
                    'accent' => $meta['accent'],
                ];
            });

        // Hero collage: pick 4 featured products with images
        $heroImages = Product::with('primaryImage')
            ->where('is_featured', true)
            ->whereHas('primaryImage')
            ->take(4)
            ->get()
            ->map(fn ($p) => [
                'url' => $p->primaryImage->url('large'),
                'alt' => $p->name,
            ])
            ->values()
            ->all();

        return view('pages.home', compact('featuredProducts', 'categories', 'heroImages'));
    }

    private static function categoryMeta(string $category): array
    {
        return match ($category) {
            'Тогооч' => [
                'subtitle' => 'Цамц, малгай, хормогч',
                'icon' => '<svg class="w-5 h-5" viewBox="0 0 64 64" fill="none"><path d="M32 8c-2 0-4 .5-5.5 1.5C24.5 8.5 22 8 20 9c-4 2-6 6-5 10.5.5 2 1.5 3.5 3 4.5v22c0 2 1.5 4 3.5 4h21c2 0 3.5-2 3.5-4V24c1.5-1 2.5-2.5 3-4.5 1-4.5-1-8.5-5-10.5-2-1-4.5-.5-6.5.5C35.5 8.5 33.5 8 32 8z" fill="#2D2926" opacity="0.85"/><rect x="22" y="42" width="20" height="3" rx="1.5" fill="white" opacity="0.5"/><rect x="22" y="36" width="20" height="3" rx="1.5" fill="white" opacity="0.3"/></svg>',
                'accent' => 'charcoal',
            ],
            'Эмнэлэг' => [
                'subtitle' => 'Халад, скраб, хувцас',
                'icon' => '<svg class="w-5 h-5" viewBox="0 0 64 64" fill="none"><rect x="24" y="8" width="16" height="48" rx="3" fill="#4A6FA5" opacity="0.85"/><rect x="8" y="24" width="48" height="16" rx="3" fill="#4A6FA5" opacity="0.85"/><rect x="28" y="12" width="8" height="40" rx="2" fill="white" opacity="0.3"/><rect x="12" y="28" width="40" height="8" rx="2" fill="white" opacity="0.3"/></svg>',
                'accent' => 'steel',
            ],
            'Нярав / Үйлчилгээ' => [
                'subtitle' => 'Хормогч, хөнжил',
                'icon' => '<svg class="w-5 h-5" viewBox="0 0 64 64" fill="none"><path d="M20 16h24v4c0 2-2 4-4 4H24c-2 0-4-2-4-4v-4z" fill="#2D2926" opacity="0.85"/><path d="M18 24h28l2 32H16l2-32z" fill="#2D2926" opacity="0.7"/><path d="M26 24v32M38 24v32" stroke="white" stroke-width="1.5" opacity="0.3"/><rect x="28" y="10" width="8" height="6" rx="2" fill="#2D2926" opacity="0.5"/></svg>',
                'accent' => 'charcoal',
            ],
            default => [
                'subtitle' => '',
                'icon' => '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="#2D2926"><path d="M20 2H4c-1 0-2 1-2 2v3c0 .7.4 1.3 1 1.7V20c0 1 1 2 2 2h14c1 0 2-1 2-2V8.7c.6-.4 1-1 1-1.7V4c0-1-1-2-2-2zm-1 18H5V9h14v11zM21 7H3V4h18v3z"/></svg>',
                'accent' => 'charcoal',
            ],
        };
    }
}
