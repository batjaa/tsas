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
            [
                'product' => [
                    'name' => 'Classic T-Shirt',
                    'description' => 'Comfortable cotton t-shirt perfect for everyday wear',
                    'category' => 'T-Shirts',
                ],
                'variants' => [
                    ['color' => 'White', 'sizes' => ['S', 'M', 'L'], 'price' => 24.99, 'stock' => 50],
                    ['color' => 'Black', 'sizes' => ['S', 'M', 'L', 'XL'], 'price' => 26.99, 'stock' => 40],
                    ['color' => 'Red', 'sizes' => ['L', 'XL'], 'price' => 26.99, 'stock' => 40],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/classic-tshirt-front/800/1000.webp', 'is_primary' => true],
                    ['url' => 'https://picsum.photos/seed/classic-tshirt-back/800/1000.webp', 'is_primary' => false],
                    ['url' => 'https://picsum.photos/seed/classic-tshirt-side/800/1000.webp', 'is_primary' => false],
                ],
            ],
            [
                'product' => [
                    'name' => 'Blue Denim Jeans',
                    'description' => 'Classic fit denim jeans with a modern touch',
                    'category' => 'Jeans',
                ],
                'variants' => [
                    ['color' => 'Blue', 'sizes' => ['30', '32', '34'], 'price' => 79.99, 'stock' => 30],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/blue-denim-jeans/800/1000.webp', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Black Leather Jacket',
                    'description' => 'Premium leather jacket with a sleek design',
                    'category' => 'Jackets',
                ],
                'variants' => [
                    ['color' => 'Black', 'sizes' => ['M', 'L'], 'price' => 199.99, 'stock' => 10],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/black-leather-jacket/800/1000.webp', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Summer Floral Dress',
                    'description' => 'Light and breezy dress perfect for summer',
                    'category' => 'Dresses',
                ],
                'variants' => [
                    ['color' => 'Floral', 'sizes' => ['S', 'M'], 'price' => 59.99, 'stock' => 25],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/summer-floral-dress/800/1000.webp', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Gray Hoodie',
                    'description' => 'Cozy hoodie for casual comfort',
                    'category' => 'Hoodies',
                ],
                'variants' => [
                    ['color' => 'Gray', 'sizes' => ['S', 'M', 'L'], 'price' => 49.99, 'stock' => 35],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/gray-hoodie/800/1000.webp', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Running Shorts',
                    'description' => 'Lightweight athletic shorts for active lifestyle',
                    'category' => 'Shorts',
                ],
                'variants' => [
                    ['color' => 'Navy', 'sizes' => ['S', 'M', 'L'], 'price' => 34.99, 'stock' => 60],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/running-shorts/800/1000.webp', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Striped Polo Shirt',
                    'description' => 'Classic polo shirt with elegant stripes',
                    'category' => 'Shirts',
                ],
                'variants' => [
                    ['color' => 'Navy/White', 'sizes' => ['M', 'L', 'XL'], 'price' => 44.99, 'stock' => 0],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/striped-polo-shirt/800/1000.webp', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Wool Winter Coat',
                    'description' => 'Warm wool coat for cold weather',
                    'category' => 'Coats',
                ],
                'variants' => [
                    ['color' => 'Charcoal', 'sizes' => ['M', 'L'], 'price' => 159.99, 'stock' => 12],
                ],
                'images' => [
                    ['url' => 'https://picsum.photos/seed/wool-winter-coat/800/1000.webp', 'is_primary' => true],
                ],
            ],
        ];

        foreach ($catalog as $data) {
            $product = Product::create($data['product']);

            $minPrice = null;
            foreach ($data['variants'] as $variantGroup) {
                foreach ($variantGroup['sizes'] as $size) {
                    $sku = Str::upper(Str::slug($product->name)) . '-' . Str::upper(Str::slug($variantGroup['color'])) . '-' . Str::upper(Str::slug($size));
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

            // Save images
            foreach ($data['images'] as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $image['url'],
                    'order' => $index,
                    'is_primary' => $image['is_primary'],
                ]);
            }

            // Update product min price
            $product->update(['min_variant_price' => $minPrice]);
        }
    }
}
