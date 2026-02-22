<?php

namespace App\Observers;

use App\Models\ProductImage;
use App\Services\ImageProcessingService;

class ProductImageObserver
{
    public function __construct(
        protected ImageProcessingService $service,
    ) {}

    public function deleting(ProductImage $image): void
    {
        $this->service->delete($image->variants, $image->path, $image->disk);
    }
}
