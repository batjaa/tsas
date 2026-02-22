<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class PageVisit extends Resource
{
    public static $model = \App\Models\PageVisit::class;

    public static $title = 'url';

    public static $search = [
        'url', 'referrer', 'ip', 'user_agent',
    ];

    public static $globallySearchable = false;

    public static function label(): string
    {
        return 'Page Visits';
    }

    public static function singularLabel(): string
    {
        return 'Page Visit';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('URL', 'url')
                ->sortable()
                ->displayUsing(fn ($value) => parse_url($value, PHP_URL_PATH) ?: '/'),

            Number::make('Status', 'status_code')
                ->sortable(),

            Text::make('Device')
                ->sortable(),

            Boolean::make('Bot', 'is_bot')
                ->sortable(),

            Text::make('Referrer')
                ->sortable(),

            Text::make('IP', 'ip')
                ->hideFromIndex(),

            Text::make('User Agent', 'user_agent')
                ->hideFromIndex(),

            BelongsTo::make('Product')
                ->nullable()
                ->sortable(),

            DateTime::make('Visited At', 'visited_at')
                ->sortable(),
        ];
    }

    public static function authorizedToCreate($request): bool
    {
        return false;
    }

    public function authorizedToUpdate($request): bool
    {
        return false;
    }

    public function authorizedToDelete($request): bool
    {
        return false;
    }

    public function authorizedToReplicate($request): bool
    {
        return false;
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
        return [];
    }
}
