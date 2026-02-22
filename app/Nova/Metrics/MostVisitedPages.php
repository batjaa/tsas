<?php

namespace App\Nova\Metrics;

use App\Models\PageVisit;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class MostVisitedPages extends Table
{
    public $name = 'Most Visited Pages';

    public function calculate(NovaRequest $request)
    {
        return PageVisit::human()
            ->select('url')
            ->selectRaw('count(*) as visit_count')
            ->groupBy('url')
            ->orderByDesc('visit_count')
            ->limit(10)
            ->get()
            ->map(fn ($row) => MetricTableRow::make()
                ->icon('eye')
                ->iconClass('text-blue-500')
                ->title(parse_url($row->url, PHP_URL_PATH) ?: '/')
                ->subtitle($row->visit_count . ' visits')
            )
            ->toArray();
    }

    public function uriKey(): string
    {
        return 'most-visited-pages';
    }
}
