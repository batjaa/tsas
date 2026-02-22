<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageProcessingService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Process an uploaded image: auto-orient, generate all variants as WebP, store to disk.
     *
     * @return array{disk: string, path: string, original_filename: string, mime_type: string, size: int, variants: array}
     */
    public function process(UploadedFile $file, int $productId): array
    {
        $disk = config('media.disk');
        $quality = config('media.quality');
        $format = config('media.format');
        $hash = substr(md5($file->getClientOriginalName() . microtime()), 0, 12);
        $basePath = "products/{$productId}";

        $image = $this->manager->read($file->getPathname());
        $image->orient();

        // Store original as WebP
        $originalPath = "{$basePath}/{$hash}-original.{$format}";
        $encoded = $image->toWebp($quality);
        Storage::disk($disk)->put($originalPath, (string) $encoded);

        // Generate variants
        $variants = [];
        foreach (config('media.variants') as $name => $settings) {
            $variant = $this->manager->read($file->getPathname());
            $variant->orient();
            $variant->scaleDown(width: $settings['width']);

            $variantPath = "{$basePath}/{$hash}-{$name}.{$format}";
            $encodedVariant = $variant->toWebp($quality);
            Storage::disk($disk)->put($variantPath, (string) $encodedVariant);

            $variants[$name] = $variantPath;
        }

        return [
            'disk' => $disk,
            'path' => $originalPath,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'variants' => $variants,
        ];
    }

    /**
     * Process an image from a local file path: auto-orient, generate all variants as WebP, store to disk.
     *
     * @return array{disk: string, path: string, original_filename: string, mime_type: string, size: int, variants: array}
     */
    public function processFromPath(string $filePath, int $productId, string $originalFilename): array
    {
        $disk = config('media.disk');
        $quality = config('media.quality');
        $format = config('media.format');
        $hash = substr(md5($originalFilename . microtime()), 0, 12);
        $basePath = "products/{$productId}";

        $image = $this->manager->read($filePath);
        $image->orient();

        // Store original as WebP
        $originalPath = "{$basePath}/{$hash}-original.{$format}";
        $encoded = $image->toWebp($quality);
        Storage::disk($disk)->put($originalPath, (string) $encoded);

        // Generate variants
        $variants = [];
        foreach (config('media.variants') as $name => $settings) {
            $variant = $this->manager->read($filePath);
            $variant->orient();
            $variant->scaleDown(width: $settings['width']);

            $variantPath = "{$basePath}/{$hash}-{$name}.{$format}";
            $encodedVariant = $variant->toWebp($quality);
            Storage::disk($disk)->put($variantPath, (string) $encodedVariant);

            $variants[$name] = $variantPath;
        }

        return [
            'disk' => $disk,
            'path' => $originalPath,
            'original_filename' => $originalFilename,
            'mime_type' => mime_content_type($filePath),
            'size' => filesize($filePath),
            'variants' => $variants,
        ];
    }

    /**
     * Delete all variant files and the original from storage.
     */
    public function delete(?array $variants, ?string $path, ?string $disk): void
    {
        if (! $disk) {
            return;
        }

        $storage = Storage::disk($disk);

        if ($path) {
            $storage->delete($path);
        }

        if ($variants) {
            foreach ($variants as $variantPath) {
                $storage->delete($variantPath);
            }
        }
    }
}
