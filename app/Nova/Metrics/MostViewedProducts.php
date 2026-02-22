<?php

namespace App\Nova\Metrics;

use App\Models\PageVisit;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class MostViewedProducts extends Table
{
    public $name = 'Most Viewed Products';

    public function calculate(NovaRequest $request)
    {
        return PageVisit::human()
            ->productViews()
            ->join('products', 'page_visits.product_id', '=', 'products.id')
            ->select('products.id', 'products.name')
            ->selectRaw('count(*) as view_count')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('view_count')
            ->limit(10)
            ->get()
            ->map(fn ($row) => MetricTableRow::make()
                ->icon('shopping-bag')
                ->iconClass('text-orange-500')
                ->title($row->name)
                ->subtitle($row->view_count . ' views')
            )
            ->toArray();
    }

    public function uriKey(): string
    {
        return 'most-viewed-products';
    }
}
