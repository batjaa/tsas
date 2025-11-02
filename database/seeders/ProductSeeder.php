<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $products = [
            [
                'product' => [
                    'name' => 'Classic White T-Shirt',
                    'description' => 'Comfortable cotton t-shirt perfect for everyday wear',
                    'price' => 29.99,
                    'category' => 'T-Shirts',
                    'size' => 'M',
                    'color' => 'White',
                    'in_stock' => true,
                ],
                'images' => [
                    ['url' => 'https://placehold.co/400x500/e0e0e0/666666?text=White+T-Shirt', 'is_primary' => true],
                    ['url' => 'https://placehold.co/400x500/e0e0e0/666666?text=White+T-Shirt+Back', 'is_primary' => false],
                    ['url' => 'https://placehold.co/400x500/e0e0e0/666666?text=White+T-Shirt+Side', 'is_primary' => false],
                ],
            ],
            [
                'product' => [
                    'name' => 'Blue Denim Jeans',
                    'description' => 'Classic fit denim jeans with a modern touch',
                    'price' => 79.99,
                    'category' => 'Jeans',
                    'size' => '32',
                    'color' => 'Blue',
                    'in_stock' => true,
                ],
                'images' => [
                    ['url' => 'https://placehold.co/400x500/4169e1/ffffff?text=Denim+Jeans', 'is_primary' => true],
                    ['url' => 'https://placehold.co/400x500/4169e1/ffffff?text=Denim+Back', 'is_primary' => false],
                ],
            ],
            [
                'product' => [
                    'name' => 'Black Leather Jacket',
                    'description' => 'Premium leather jacket with a sleek design',
                    'price' => 199.99,
                    'category' => 'Jackets',
                    'size' => 'L',
                    'color' => 'Black',
                    'in_stock' => true,
                ],
                'images' => [
                    ['url' => 'https://placehold.co/400x500/1a1a1a/ffffff?text=Leather+Jacket', 'is_primary' => true],
                    ['url' => 'https://placehold.co/400x500/1a1a1a/ffffff?text=Jacket+Detail', 'is_primary' => false],
                    ['url' => 'https://placehold.co/400x500/1a1a1a/ffffff?text=Jacket+Side', 'is_primary' => false],
                    ['url' => 'https://placehold.co/400x500/1a1a1a/ffffff?text=Jacket+Back', 'is_primary' => false],
                ],
            ],
            [
                'product' => [
                    'name' => 'Summer Floral Dress',
                    'description' => 'Light and breezy dress perfect for summer',
                    'price' => 59.99,
                    'category' => 'Dresses',
                    'size' => 'S',
                    'color' => 'Floral',
                    'in_stock' => true,
                ],
                'images' => [
                    ['url' => 'https://placehold.co/400x500/ffb6c1/ffffff?text=Floral+Dress', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Gray Hoodie',
                    'description' => 'Cozy hoodie for casual comfort',
                    'price' => 49.99,
                    'category' => 'Hoodies',
                    'size' => 'M',
                    'color' => 'Gray',
                    'in_stock' => true,
                ],
                'images' => [
                    ['url' => 'https://placehold.co/400x500/808080/ffffff?text=Gray+Hoodie', 'is_primary' => true],
                    ['url' => 'https://placehold.co/400x500/808080/ffffff?text=Hoodie+Back', 'is_primary' => false],
                ],
            ],
            [
                'product' => [
                    'name' => 'Running Shorts',
                    'description' => 'Lightweight athletic shorts for active lifestyle',
                    'price' => 34.99,
                    'category' => 'Shorts',
                    'size' => 'M',
                    'color' => 'Navy',
                    'in_stock' => true,
                ],
                'images' => [
                    ['url' => 'https://placehold.co/400x500/000080/ffffff?text=Running+Shorts', 'is_primary' => true],
                    ['url' => 'https://placehold.co/400x500/000080/ffffff?text=Shorts+Detail', 'is_primary' => false],
                ],
            ],
            [
                'product' => [
                    'name' => 'Striped Polo Shirt',
                    'description' => 'Classic polo shirt with elegant stripes',
                    'price' => 44.99,
                    'category' => 'Shirts',
                    'size' => 'L',
                    'color' => 'Striped',
                    'in_stock' => false,
                ],
                'images' => [
                    ['url' => 'https://placehold.co/400x500/add8e6/000000?text=Polo+Shirt', 'is_primary' => true],
                ],
            ],
            [
                'product' => [
                    'name' => 'Wool Winter Coat',
                    'description' => 'Warm wool coat for cold weather',
                    'price' => 159.99,
                    'category' => 'Coats',
                    'size' => 'M',
                    'color' => 'Charcoal',
                    'in_stock' => true,
                ],
                'images' => [
                    ['url' => 'https://placehold.co/400x500/36454f/ffffff?text=Winter+Coat', 'is_primary' => true],
                    ['url' => 'https://placehold.co/400x500/36454f/ffffff?text=Coat+Side', 'is_primary' => false],
                    ['url' => 'https://placehold.co/400x500/36454f/ffffff?text=Coat+Detail', 'is_primary' => false],
                ],
            ],
        ];

        foreach ($products as $data) {
            $product = Product::create($data['product']);

            foreach ($data['images'] as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $image['url'],
                    'order' => $index,
                    'is_primary' => $image['is_primary'],
                ]);
            }
        }
    }
}
