<?php

namespace App\Nova\Metrics;

use App\Models\PageVisit;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class TopNotFoundUrls extends Table
{
    public $name = 'Top 404 URLs';

    public function calculate(NovaRequest $request)
    {
        return PageVisit::human()
            ->notFound()
            ->select('url')
            ->selectRaw('count(*) as hit_count')
            ->groupBy('url')
            ->orderByDesc('hit_count')
            ->limit(10)
            ->get()
            ->map(fn ($row) => MetricTableRow::make()
                ->icon('exclamation-circle')
                ->iconClass('text-red-500')
                ->title(parse_url($row->url, PHP_URL_PATH) ?: $row->url)
                ->subtitle($row->hit_count . ' hits')
            )
            ->toArray();
    }

    public function uriKey(): string
    {
        return 'top-not-found-urls';
    }
}
