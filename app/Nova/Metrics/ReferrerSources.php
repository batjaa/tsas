<?php

namespace App\Nova\Metrics;

use App\Models\PageVisit;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class ReferrerSources extends Partition
{
    public $name = 'Referrer Sources';

    public function calculate(NovaRequest $request)
    {
        return $this->count(
            $request,
            PageVisit::human()->whereNotNull('referrer'),
            'referrer',
        )->label(fn ($label) => $label ?: 'Unknown');
    }

    public function uriKey(): string
    {
        return 'referrer-sources';
    }
}
