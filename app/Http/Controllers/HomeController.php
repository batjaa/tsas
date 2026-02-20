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

        $categories = DB::table('products')
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get()
            ->map(function ($row) {
                $meta = self::categoryMeta($row->category);
                return [
                    'title' => $row->category,
                    'subtitle' => $meta['subtitle'],
                    'count' => $row->count,
                    'image' => $meta['image'],
                    'icon' => $meta['icon'],
                ];
            });

        return view('pages.home', compact('featuredProducts', 'categories'));
    }

    private static function categoryMeta(string $category): array
    {
        return match ($category) {
            'Тогооч' => [
                'subtitle' => 'Гал тогооны хувцас',
                'image' => 'https://picsum.photos/seed/cat-chef/400/300.webp',
                'icon' => '🍳',
            ],
            'Эмнэлэг' => [
                'subtitle' => 'Эмнэлгийн хувцас',
                'image' => 'https://picsum.photos/seed/cat-medical/400/300.webp',
                'icon' => '🏥',
            ],
            'Нярав / Үйлчилгээ' => [
                'subtitle' => 'Үйлчилгээний хувцас',
                'image' => 'https://picsum.photos/seed/cat-service/400/300.webp',
                'icon' => '🧹',
            ],
            'Нарийн боовчин' => [
                'subtitle' => 'Боовны цехийн хувцас',
                'image' => 'https://picsum.photos/seed/cat-baker/400/300.webp',
                'icon' => '🧁',
            ],
            default => [
                'subtitle' => '',
                'image' => 'https://picsum.photos/seed/cat-default/400/300.webp',
                'icon' => '📦',
            ],
        };
    }
}
