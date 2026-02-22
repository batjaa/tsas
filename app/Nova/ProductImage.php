<?php

namespace App\Nova;

use App\Nova\Actions\SetPrimaryImage;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ProductImage extends Resource
{
    public static $model = \App\Models\ProductImage::class;

    public static $title = 'original_filename';

    public static $search = [
        'id', 'original_filename',
    ];

    public static $displayInNavigation = false;

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Product')
                ->sortable()
                ->rules('required'),

            Image::make('Thumbnail', 'path')
                ->exceptOnForms()
                ->thumbnail(function ($value, $disk) {
                    return $this->resource->url('thumbnail');
                })
                ->preview(function ($value, $disk) {
                    return $this->resource->url('medium');
                }),

            Text::make('Original Filename')
                ->exceptOnForms()
                ->hideFromIndex(),

            Text::make('Mime Type')
                ->exceptOnForms()
                ->hideFromIndex(),

            Text::make('Size', function () {
                if (! $this->resource->size) {
                    return null;
                }
                return number_format($this->resource->size / 1024, 1) . ' KB';
            })
                ->exceptOnForms()
                ->hideFromIndex(),

            Number::make('Order')
                ->sortable()
                ->rules('required', 'integer', 'min:0')
                ->default(0),

            Boolean::make('Is Primary')
                ->sortable(),

            Select::make('Hero Position', 'hero_position')
                ->options([
                    1 => 'Байрлал 1 (зүүн дээд, том)',
                    2 => 'Байрлал 2 (баруун дээд)',
                    3 => 'Байрлал 3 (зүүн доод)',
                    4 => 'Байрлал 4 (баруун доод)',
                ])
                ->displayUsingLabels()
                ->nullable()
                ->rules(
                    'nullable',
                    'integer',
                    'in:1,2,3,4',
                    function ($attribute, $value, $fail) {
                        if ($value === null) {
                            return;
                        }
                        $existing = \App\Models\ProductImage::where('hero_position', $value)
                            ->where('id', '!=', $this->resource->id ?? 0)
                            ->first();
                        if ($existing) {
                            $productName = $existing->product?->name ?? "#{$existing->product_id}";
                            $fail("Hero байрлал {$value} аль хэдийн \"{$productName}\" бүтээгдэхүүний зуранд оноогдсон байна.");
                        }
                    }
                )
                ->help('Нүүр хуудасны hero зургийн байрлал сонгоно уу'),

            Code::make('Variants')
                ->json()
                ->exceptOnForms()
                ->hideFromIndex(),
        ];
    }

    public function cards(NovaRequest $request): array
    {
        return [];
    }

    public function filters(NovaRequest $request): array
    {
        return [];
    }

    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            new SetPrimaryImage,
        ];
    }
}
