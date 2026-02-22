<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\DeviceBreakdown;
use App\Nova\Metrics\MostVisitedPages;
use App\Nova\Metrics\MostViewedProducts;
use App\Nova\Metrics\NotFoundHits;
use App\Nova\Metrics\ReferrerSources;
use App\Nova\Metrics\TopNotFoundUrls;
use App\Nova\Metrics\TotalVisitors;
use App\Nova\Metrics\VisitorsTrend;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    public function cards(): array
    {
        return [
            // Row 1
            (new TotalVisitors)->width('1/3'),
            (new NotFoundHits)->width('1/3'),
            (new DeviceBreakdown)->width('1/3'),

            // Row 2
            (new VisitorsTrend)->width('2/3'),
            (new ReferrerSources)->width('1/3'),

            // Row 3
            (new MostVisitedPages)->width('1/2'),
            (new MostViewedProducts)->width('1/2'),

            // Row 4
            (new TopNotFoundUrls)->width('full'),
        ];
    }
}
