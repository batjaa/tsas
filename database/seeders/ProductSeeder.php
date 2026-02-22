<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            // --- Тогооч (Chef) ---
            [
                'product' => [
                    'name' => 'Тогоочийн хантааз — Классик цагаан',
                    'description' => 'Хоёр эгнээ товчтой сонгодог загварын тогоочийн хантааз. Халуунд тэсвэртэй хөвөн даавуу, давхар товчтой.',
                    'category' => 'Тогооч',
                    'is_featured' => true,
                    'badge' => 'Шинэ',
                ],
                'variants' => [
                    ['color' => 'Цагаан', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 65000, 'stock' => 40],
                    ['color' => 'Хар', 'sizes' => ['S', 'M', 'L', 'XL'], 'price' => 65000, 'stock' => 30],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/chef-jacket-white/800/1000.webp', 'is_primary' => true],
                    ['url' => 'https://picsum.photos/seed/chef-jacket-back/800/1000.webp', 'is_primary' => false],
                ],
            ],
            [
                'product' => [
                    'name' => 'Тогоочийн өмд — Зурвас',
                    'description' => 'Уян хатан бүсэлхийтэй, тав тухтай тогоочийн өмд. Зурвас хээтэй сонгодог загвар.',
                    'category' => 'Тогооч',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Хар зурвас', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 45000, 'stock' => 50],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/chef-pants-stripe/800/1000.webp', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Тогоочийн малгай — Пилотка',
                    'description' => 'Хөнгөн, агааржуулалттай пилотка загварын тогоочийн малгай.',
                    'category' => 'Тогооч',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Цагаан', 'sizes' => ['M', 'L'], 'price' => 15000, 'stock' => 60],
                    ['color' => 'Хар', 'sizes' => ['M', 'L'], 'price' => 15000, 'stock' => 40],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/chef-hat-pilotka/800/1000.webp', 'is_primary' => true],
                ],
            ],

            // --- Эмнэлэг (Medical) ---
            [
                'product' => [
                    'name' => 'Эмчийн халад — Цэнхэр',
                    'description' => 'Урт ханцуйтай эмчийн халад. Зөөлөн, амьсгалдаг даавуугаар хийгдсэн.',
                    'category' => 'Эмнэлэг',
                    'is_featured' => true,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Цэнхэр', 'sizes' => ['S', 'M', 'L', 'XL', '2XL', '3XL'], 'price' => 55000, 'stock' => 35],
                    ['color' => 'Цагаан', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 55000, 'stock' => 25],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/medical-coat-blue/800/1000.webp', 'is_primary' => true],
                    ['url' => 'https://picsum.photos/seed/medical-coat-back/800/1000.webp', 'is_primary' => false],
                ],
            ],
            [
                'product' => [
                    'name' => 'Сувилагчийн костюм — Скраб',
                    'description' => 'V хүзүүтэй скраб цамц + өмд. Эмнэлэг, лабораторид тохиромжтой.',
                    'category' => 'Эмнэлэг',
                    'is_featured' => true,
                    'badge' => 'Хит',
                ],
                'variants' => [
                    ['color' => 'Цэнхэр', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 49000, 'stock' => 45],
                    ['color' => 'Ногоон', 'sizes' => ['S', 'M', 'L', 'XL'], 'price' => 49000, 'stock' => 30],
                    ['color' => 'Ягаан', 'sizes' => ['S', 'M', 'L'], 'price' => 49000, 'stock' => 20],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/scrub-set-blue/800/1000.webp', 'is_primary' => true],
                    ['url' => 'https://picsum.photos/seed/scrub-set-green/800/1000.webp', 'is_primary' => false],
                ],
            ],

            // --- Нярав / Үйлчилгээ (Service) ---
            [
                'product' => [
                    'name' => 'Зөөгчийн цамц — Хар',
                    'description' => 'Товчтой сонгодог загварын зөөгчийн цамц. Тохилог даавуу, бүх улирлын хувцас.',
                    'category' => 'Нярав / Үйлчилгээ',
                    'is_featured' => true,
                    'badge' => 'Хит',
                ],
                'variants' => [
                    ['color' => 'Хар', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 45000, 'stock' => 55],
                    ['color' => 'Цагаан', 'sizes' => ['S', 'M', 'L', 'XL'], 'price' => 45000, 'stock' => 35],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/waiter-shirt-black/800/1000.webp', 'is_primary' => true],
                    ['url' => 'https://picsum.photos/seed/waiter-shirt-white/800/1000.webp', 'is_primary' => false],
                ],
            ],
            [
                'product' => [
                    'name' => 'Үйлчилгээний фартук — Бүсэлхий',
                    'description' => 'Бүсэлхийн урт фартук. Ресторан, кофе шоп-д тохиромжтой.',
                    'category' => 'Нярав / Үйлчилгээ',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Хар', 'sizes' => ['M', 'L'], 'price' => 35000, 'stock' => 40],
                    ['color' => 'Бор', 'sizes' => ['M', 'L'], 'price' => 35000, 'stock' => 25],
                    ['color' => 'Улбар шар', 'sizes' => ['M', 'L'], 'price' => 38000, 'stock' => 15],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/service-apron-black/800/1000.webp', 'is_primary' => true],
                ],
            ],

            // --- Нарийн боовчин (Baker/Pastry) ---
            [
                'product' => [
                    'name' => 'Нарийн боовчны фартук — Бүтэн',
                    'description' => 'Гурил, тос тэсвэртэй бүтэн фартук. Нарийн боовны цехэд зориулсан.',
                    'category' => 'Нарийн боовчин',
                    'is_featured' => true,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Улбар шар', 'sizes' => ['M', 'L', 'XL'], 'price' => 39000, 'stock' => 30],
                    ['color' => 'Хар', 'sizes' => ['M', 'L', 'XL'], 'price' => 39000, 'stock' => 25],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/baker-apron-orange/800/1000.webp', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Нарийн боовчны малгай — Берет',
                    'description' => 'Сонгодог загварын берет малгай. Нарийн боовчин, тогоочид зориулсан.',
                    'category' => 'Нарийн боовчин',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Цагаан', 'sizes' => ['M', 'L'], 'price' => 18000, 'stock' => 45],
                    ['color' => 'Хар', 'sizes' => ['M', 'L'], 'price' => 18000, 'stock' => 30],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/baker-beret-white/800/1000.webp', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Тогоочийн хантааз — Богино ханцуй',
                    'description' => 'Зуны улиралд зориулсан богино ханцуйтай тогоочийн хантааз. Агааржуулалттай даавуу.',
                    'category' => 'Тогооч',
                    'is_featured' => true,
                    'badge' => 'Шинэ',
                ],
                'variants' => [
                    ['color' => 'Цагаан', 'sizes' => ['S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'], 'price' => 59000, 'stock' => 50],
                    ['color' => 'Саарал', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 62000, 'stock' => 20],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/chef-jacket-short/800/1000.webp', 'is_primary' => true],
                    ['url' => 'https://picsum.photos/seed/chef-jacket-short-back/800/1000.webp', 'is_primary' => false],
                ],
            ],
            [
                'product' => [
                    'name' => 'Эмнэлгийн бээлий — Нитрил',
                    'description' => 'Нэг удаагийн нитрил бээлий. 100ш/хайрцаг. Латекс агуулаагүй.',
                    'category' => 'Эмнэлэг',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Цэнхэр', 'sizes' => ['S', 'M', 'L', 'XL'], 'price' => 25000, 'stock' => 100],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/nitrile-gloves-blue/800/1000.webp', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Эмнэлгийн маск — 3 давхар',
                    'description' => '3 давхар хамгаалалттай нэг удаагийн маск. 50ш/хайрцаг.',
                    'category' => 'Эмнэлэг',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Цэнхэр', 'sizes' => ['M'], 'price' => 15000, 'stock' => 200],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/medical-mask-blue/800/1000.webp', 'is_primary' => true],
                ],
            ],
        ];

        foreach ($catalog as $data) {
            $product = Product::create($data['product']);

            $minPrice = null;
            foreach ($data['variants'] as $variantGroup) {
                foreach ($variantGroup['sizes'] as $size) {
                    $sku = Str::upper(Str::slug($product->name, '-')) . '-' . Str::upper(Str::slug($variantGroup['color'])) . '-' . Str::upper(Str::slug($size));
                    // Truncate SKU if too long
                    $sku = Str::limit($sku, 50, '');
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => $sku,
                        'size' => $size,
                        'color' => $variantGroup['color'],
                        'price' => $variantGroup['price'],
                        'stock' => $variantGroup['stock'],
                        'is_available' => $variantGroup['stock'] > 0,
                    ]);
                    $minPrice = is_null($minPrice) ? $variant->price : min($minPrice, $variant->price);
                }
            }

            foreach ($data['images'] as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'disk' => null,
                    'path' => null,
                    'variants' => null,
                    'order' => $index,
                    'is_primary' => $image['is_primary'],
                ]);
            }

            $product->update(['min_variant_price' => $minPrice]);
        }
    }
}
