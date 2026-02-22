<?php

namespace App\Nova\Metrics;

use App\Models\PageVisit;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class NotFoundHits extends Value
{
    public $name = '404 Hits';

    public function calculate(NovaRequest $request)
    {
        return $this->count($request, PageVisit::human()->notFound(), dateColumn: 'visited_at');
    }

    public function ranges(): array
    {
        return [
            'TODAY' => 'Today',
            7 => '7 Days',
            30 => '30 Days',
            60 => '60 Days',
            365 => '365 Days',
        ];
    }

    public function uriKey(): string
    {
        return 'not-found-hits';
    }
}
