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
            // 1. Тогоочийн хантааз — Классик цагаан
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
                ],
                'images' => [
                    ['filename' => 'px-2', 'is_primary' => true],
                    ['filename' => 'px-4', 'is_primary' => false],
                    ['filename' => 'px-5', 'is_primary' => false],
                    ['filename' => 'px-6', 'is_primary' => false],
                ],
            ],
            // 2. Тогоочийн малгай — Бандана
            [
                'product' => [
                    'name' => 'Тогоочийн малгай — Бандана',
                    'description' => 'Хөнгөн, агааржуулалттай бандана загварын тогоочийн малгай. Гал тогооны орчинд тохиромжтой.',
                    'category' => 'Тогооч',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Хар', 'sizes' => ['M', 'L'], 'price' => 15000, 'stock' => 60],
                ],
                'images' => [],
            ],
            // 3. Тогоочийн өмд — Хар
            [
                'product' => [
                    'name' => 'Тогоочийн өмд — Хар',
                    'description' => 'Уян хатан бүсэлхийтэй, тав тухтай тогоочийн өмд. Хар өнгөтэй сонгодог загвар.',
                    'category' => 'Тогооч',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Хар', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 45000, 'stock' => 50],
                ],
                'images' => [
                    ['filename' => 'px-4', 'is_primary' => true],
                ],
            ],
            // 4. Тогоочийн хантааз — Зурвас хээтэй
            [
                'product' => [
                    'name' => 'Тогоочийн хантааз — Зурвас хээтэй',
                    'description' => 'Зурвас хээ чимэглэлтэй тогоочийн хантааз. Давхар товчтой, загварлаг дизайн.',
                    'category' => 'Тогооч',
                    'is_featured' => true,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Цагаан', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 65000, 'stock' => 35],
                ],
                'images' => [
                    ['filename' => 'px-22', 'is_primary' => true],
                ],
            ],
            // 5. Тогоочийн фартук — Зурвас хээ
            [
                'product' => [
                    'name' => 'Тогоочийн фартук — Зурвас хээ',
                    'description' => 'Зурвас хээтэй тогоочийн фартук. Бүсэлхийн уртатай, гал тогооны орчинд тохиромжтой.',
                    'category' => 'Тогооч',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Зурвас', 'sizes' => ['M', 'L'], 'price' => 35000, 'stock' => 40],
                ],
                'images' => [
                    ['filename' => 'px-12', 'is_primary' => true],
                    ['filename' => 'px-18', 'is_primary' => false],
                ],
            ],
            // 6. Тогоочийн өмд — Зурвас хээ
            [
                'product' => [
                    'name' => 'Тогоочийн өмд — Зурвас хээ',
                    'description' => 'Уян хатан бүсэлхийтэй, зурвас хээтэй тогоочийн өмд.',
                    'category' => 'Тогооч',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Зурвас', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 45000, 'stock' => 45],
                ],
                'images' => [
                    ['filename' => 'px-14', 'is_primary' => true],
                ],
            ],
            // 7. Нярав фартук — Табард
            [
                'product' => [
                    'name' => 'Нярав фартук — Табард',
                    'description' => 'Табард загварын нярав фартук. Үйлчилгээ, цэвэрлэгээний ажилд тохиромжтой. Олон өнгөтэй.',
                    'category' => 'Нярав / Үйлчилгээ',
                    'is_featured' => true,
                    'badge' => 'Хит',
                ],
                'variants' => [
                    ['color' => 'Ягаан', 'sizes' => ['M', 'L', 'XL'], 'price' => 25000, 'stock' => 30],
                    ['color' => 'Цэнхэр', 'sizes' => ['M', 'L', 'XL'], 'price' => 25000, 'stock' => 30],
                    ['color' => 'Нил ягаан', 'sizes' => ['M', 'L', 'XL'], 'price' => 25000, 'stock' => 25],
                    ['color' => 'Улаан', 'sizes' => ['M', 'L', 'XL'], 'price' => 25000, 'stock' => 25],
                ],
                'images' => [
                    ['filename' => 'px-10', 'is_primary' => true],
                    ['filename' => 'px-11', 'is_primary' => false],
                    ['filename' => 'px-26', 'is_primary' => false],
                    ['filename' => 'px-28', 'is_primary' => false],
                    ['filename' => 'px-29', 'is_primary' => false],
                    ['filename' => 'px-30', 'is_primary' => false],
                    ['filename' => 'px-32', 'is_primary' => false],
                ],
            ],
            // 8. Эмчийн халад — Цэнхэр
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
                ],
                'images' => [
                    ['filename' => 'px-34', 'is_primary' => true],
                    ['filename' => 'px-36', 'is_primary' => false],
                    ['filename' => 'px-38', 'is_primary' => false],
                    ['filename' => 'px-40', 'is_primary' => false],
                    ['filename' => 'px-64', 'is_primary' => false],
                ],
            ],
            // 9. Сувилагчийн костюм — Скраб хөх
            [
                'product' => [
                    'name' => 'Сувилагчийн костюм — Скраб хөх',
                    'description' => 'V хүзүүтэй скраб цамц + өмд. Эмнэлэг, лабораторид тохиромжтой. Хөх өнгө.',
                    'category' => 'Эмнэлэг',
                    'is_featured' => true,
                    'badge' => 'Хит',
                ],
                'variants' => [
                    ['color' => 'Хөх', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 49000, 'stock' => 45],
                ],
                'images' => [
                    ['filename' => 'px-42', 'is_primary' => true],
                    ['filename' => 'px-44', 'is_primary' => false],
                ],
            ],
            // 10. Сувилагчийн костюм — Скраб улаан
            [
                'product' => [
                    'name' => 'Сувилагчийн костюм — Скраб улаан',
                    'description' => 'V хүзүүтэй скраб цамц + өмд. Эмнэлэг, лабораторид тохиромжтой. Улаан өнгө.',
                    'category' => 'Эмнэлэг',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Улаан', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 49000, 'stock' => 40],
                ],
                'images' => [
                    ['filename' => 'px-46', 'is_primary' => true],
                    ['filename' => 'px-48', 'is_primary' => false],
                    ['filename' => 'px-50', 'is_primary' => false],
                ],
            ],
            // 11. Эмнэлгийн костюм — Цэцэгтэй
            [
                'product' => [
                    'name' => 'Эмнэлгийн костюм — Цэцэгтэй',
                    'description' => 'Цэцэгтэй хээтэй эмнэлгийн костюм. Хүүхдийн эмч, шүдний эмчид тохиромжтой.',
                    'category' => 'Эмнэлэг',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Цэцэгтэй хөх', 'sizes' => ['S', 'M', 'L', 'XL'], 'price' => 49000, 'stock' => 30],
                ],
                'images' => [
                    ['filename' => 'px-52', 'is_primary' => true],
                    ['filename' => 'px-54', 'is_primary' => false],
                    ['filename' => 'px-56', 'is_primary' => false],
                ],
            ],
            // 12. Тогоочийн хантааз — Улаан
            [
                'product' => [
                    'name' => 'Тогоочийн хантааз — Улаан',
                    'description' => 'Улаан өнгөтэй тогоочийн хантааз. Давхар товчтой, загварлаг дизайн.',
                    'category' => 'Тогооч',
                    'is_featured' => true,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Улаан', 'sizes' => ['S', 'M', 'L', 'XL', '2XL'], 'price' => 65000, 'stock' => 30],
                ],
                'images' => [
                    ['filename' => 'px-58', 'is_primary' => true],
                    ['filename' => 'px-60', 'is_primary' => false],
                ],
            ],
            // 13. Тогоочийн малгай — Пилотка
            [
                'product' => [
                    'name' => 'Тогоочийн малгай — Пилотка',
                    'description' => 'Хөнгөн, агааржуулалттай пилотка загварын тогоочийн малгай.',
                    'category' => 'Тогооч',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Хар', 'sizes' => ['M', 'L'], 'price' => 15000, 'stock' => 40],
                    ['color' => 'Улаан', 'sizes' => ['M', 'L'], 'price' => 15000, 'stock' => 30],
                ],
                'images' => [],
            ],
            // 14. Тогоочийн малгай — Берет (зурвас)
            [
                'product' => [
                    'name' => 'Тогоочийн малгай — Берет (зурвас)',
                    'description' => 'Зурвас хээтэй берет загварын тогоочийн малгай. Нарийн боовчин, тогоочид зориулсан.',
                    'category' => 'Тогооч',
                    'is_featured' => false,
                    'badge' => null,
                ],
                'variants' => [
                    ['color' => 'Зурвас', 'sizes' => ['M', 'L'], 'price' => 18000, 'stock' => 35],
                ],
                'images' => [],
            ],
        ];

        foreach ($catalog as $data) {
            $product = Product::create($data['product']);

            $minPrice = null;
            foreach ($data['variants'] as $variantGroup) {
                foreach ($variantGroup['sizes'] as $size) {
                    $sku = Str::upper(Str::slug($product->name, '-')) . '-' . Str::upper(Str::slug($variantGroup['color'])) . '-' . Str::upper(Str::slug($size));
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
