<?php

namespace App\Nova\Metrics;

use App\Models\PageVisit;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class DeviceBreakdown extends Partition
{
    public $name = 'Device Breakdown';

    public function calculate(NovaRequest $request)
    {
        return $this->count($request, PageVisit::human(), 'device')
            ->label(fn ($label) => match ($label) {
                'desktop' => 'Desktop',
                'mobile' => 'Mobile',
                'tablet' => 'Tablet',
                default => ucfirst($label),
            })
            ->colors([
                'Desktop' => '#4A6FA5',
                'Mobile' => '#E8651A',
                'Tablet' => '#2D2926',
            ]);
    }

    public function uriKey(): string
    {
        return 'device-breakdown';
    }
}
