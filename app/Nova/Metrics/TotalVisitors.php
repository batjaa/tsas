<?php

namespace App\Nova\Metrics;

use App\Models\PageVisit;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalVisitors extends Value
{
    public $name = 'Total Visitors';

    public function calculate(NovaRequest $request)
    {
        return $this->count($request, PageVisit::human(), dateColumn: 'visited_at');
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
        return 'total-visitors';
    }
}
