<?php

namespace App\Nova\Actions;

use App\Models\ProductImage;
use App\Services\ImageProcessingService;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\NovaRequest;

class UploadProductImages extends Action
{
    public $name = 'Upload Image';

    public $showOnTableRow = false;

    public function handle(ActionFields $fields, Collection $models): mixed
    {
        $product = $models->first();
        $file = $fields->image;

        if (! $file || ! $product) {
            return Action::danger('No image or product provided.');
        }

        $service = app(ImageProcessingService::class);
        $metadata = $service->process($file, $product->id);

        $isFirst = $product->images()->count() === 0;

        ProductImage::create([
            'product_id' => $product->id,
            'disk' => $metadata['disk'],
            'path' => $metadata['path'],
            'original_filename' => $metadata['original_filename'],
            'mime_type' => $metadata['mime_type'],
            'size' => $metadata['size'],
            'variants' => $metadata['variants'],
            'order' => $product->images()->max('order') + 1,
            'is_primary' => $isFirst,
        ]);

        return Action::message('Image uploaded and processed successfully.');
    }

    public function fields(NovaRequest $request): array
    {
        return [
            File::make('Image')
                ->rules('required', 'image', 'max:10240')
                ->acceptedTypes('image/*'),
        ];
    }
}
