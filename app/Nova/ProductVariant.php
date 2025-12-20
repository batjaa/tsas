<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class ProductVariant extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ProductVariant>
     */
    public static $model = \App\Models\ProductVariant::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'sku';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'sku', 'size', 'color',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Product')
                ->sortable()
                ->rules('required')
                ->searchable(),

            Text::make('SKU', 'sku')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:product_variants,sku')
                ->updateRules('unique:product_variants,sku,{{resourceId}}'),

            Text::make('Size', 'size')
                ->sortable()
                ->nullable()
                ->rules('nullable', 'max:50'),

            Text::make('Color', 'color')
                ->sortable()
                ->nullable()
                ->rules('nullable', 'max:50'),

            Number::make('Price', 'price')
                ->sortable()
                ->rules('required', 'numeric', 'min:0')
                ->step(0.01),

            Number::make('Stock', 'stock')
                ->sortable()
                ->rules('required', 'integer', 'min:0')
                ->default(0),

            Boolean::make('Is Available', 'is_available')
                ->sortable()
                ->trueValue(true)
                ->falseValue(false),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
