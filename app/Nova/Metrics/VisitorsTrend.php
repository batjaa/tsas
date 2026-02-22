<?php

namespace App\Nova\Metrics;

use App\Models\PageVisit;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class VisitorsTrend extends Trend
{
    public $name = 'Visitors Trend';

    public function calculate(NovaRequest $request)
    {
        return $this->countByDays($request, PageVisit::human(), 'visited_at')
            ->showSumValue();
    }

    public function ranges(): array
    {
        return [
            7 => '7 Days',
            14 => '14 Days',
            30 => '30 Days',
            60 => '60 Days',
        ];
    }

    public function uriKey(): string
    {
        return 'visitors-trend';
    }
}
