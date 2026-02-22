<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ImageProcessingService;
use Illuminate\Console\Command;

class SeedProductImages extends Command
{
    protected $signature = 'products:seed-images {path : Path to directory containing lookbook images}';

    protected $description = 'Process lookbook images and seed product images to configured media disk';

    /**
     * Filename suffix → [product name(s)] mapping.
     * Key is the "px-N" suffix, value is array of product names this image belongs to.
     */
    protected array $imageMap = [
        'px-2'  => ['Тогоочийн хантааз — Классик цагаан'],
        'px-4'  => ['Тогоочийн хантааз — Классик цагаан', 'Тогоочийн өмд — Хар'],
        'px-5'  => ['Тогоочийн хантааз — Классик цагаан'],
        'px-6'  => ['Тогоочийн хантааз — Классик цагаан'],
        'px-12' => ['Тогоочийн фартук — Зурвас хээ'],
        'px-18' => ['Тогоочийн фартук — Зурвас хээ'],
        'px-14' => ['Тогоочийн өмд — Зурвас хээ'],
        'px-22' => ['Тогоочийн хантааз — Зурвас хээтэй'],
        'px-10' => ['Нярав фартук — Табард'],
        'px-11' => ['Нярав фартук — Табард'],
        'px-26' => ['Нярав фартук — Табард'],
        'px-28' => ['Нярав фартук — Табард'],
        'px-29' => ['Нярав фартук — Табард'],
        'px-30' => ['Нярав фартук — Табард'],
        'px-32' => ['Нярав фартук — Табард'],
        'px-34' => ['Эмчийн халад — Цэнхэр'],
        'px-36' => ['Эмчийн халад — Цэнхэр'],
        'px-38' => ['Эмчийн халад — Цэнхэр'],
        'px-40' => ['Эмчийн халад — Цэнхэр'],
        'px-64' => ['Эмчийн халад — Цэнхэр'],
        'px-42' => ['Сувилагчийн костюм — Скраб хөх'],
        'px-44' => ['Сувилагчийн костюм — Скраб хөх'],
        'px-46' => ['Сувилагчийн костюм — Скраб улаан'],
        'px-48' => ['Сувилагчийн костюм — Скраб улаан'],
        'px-50' => ['Сувилагчийн костюм — Скраб улаан'],
        'px-52' => ['Эмнэлгийн костюм — Цэцэгтэй'],
        'px-54' => ['Эмнэлгийн костюм — Цэцэгтэй'],
        'px-56' => ['Эмнэлгийн костюм — Цэцэгтэй'],
        'px-58' => ['Тогоочийн хантааз — Улаан'],
        'px-60' => ['Тогоочийн хантааз — Улаан'],
    ];

    public function handle(ImageProcessingService $imageService): int
    {
        $path = rtrim($this->argument('path'), '/');

        if (! is_dir($path)) {
            $this->error("Directory not found: {$path}");
            return self::FAILURE;
        }

        // Load all products by name for lookup
        $products = Product::all()->keyBy('name');

        // Track image order per product
        $orderCounters = [];
        // Track which products have had their first image set as primary
        $primarySet = [];

        $processed = 0;
        $skipped = 0;

        foreach ($this->imageMap as $suffix => $productNames) {
            // Build the filename — "px-2" → "Uniform-Lookbook-2021-Mongolia-2000px-2.jpg"
            $number = str_replace('px-', '', $suffix);
            $filename = "Uniform-Lookbook-2021-Mongolia-2000px-{$number}.jpg";
            $filePath = "{$path}/{$filename}";

            if (! file_exists($filePath)) {
                $this->warn("File not found, skipping: {$filename}");
                $skipped++;
                continue;
            }

            foreach ($productNames as $productName) {
                $product = $products->get($productName);
                if (! $product) {
                    $this->warn("Product not found: {$productName}");
                    $skipped++;
                    continue;
                }

                $this->info("Processing {$filename} → {$productName}");

                $result = $imageService->processFromPath($filePath, $product->id, $filename);

                $order = $orderCounters[$product->id] ?? 0;
                $isPrimary = ! isset($primarySet[$product->id]);

                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'original_filename' => $filename,
                    ],
                    [
                        'disk' => $result['disk'],
                        'path' => $result['path'],
                        'original_filename' => $result['original_filename'],
                        'mime_type' => $result['mime_type'],
                        'size' => $result['size'],
                        'variants' => $result['variants'],
                        'order' => $order,
                        'is_primary' => $isPrimary,
                    ]
                );

                $orderCounters[$product->id] = $order + 1;
                $primarySet[$product->id] = true;
                $processed++;
            }
        }

        // Clean up placeholder image records (disk = null) for products that now have real images
        $placeholders = ProductImage::whereNull('disk')
            ->whereIn('product_id', array_keys($primarySet))
            ->delete();

        if ($placeholders > 0) {
            $this->info("Removed {$placeholders} placeholder image records.");
        }

        $this->newLine();
        $this->info("Done! Processed: {$processed}, Skipped: {$skipped}");

        return self::SUCCESS;
    }
}
