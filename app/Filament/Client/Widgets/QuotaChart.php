<?php

namespace App\Filament\Client\Widgets;

use App\Models\Quota;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class QuotaChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'QuotaChart';
    protected static ?int $sort = 6;
    protected static ?string $maxHeight = '350px';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'QuotaChart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $data = Trend::model(Quota::class)
            ->query(  
                Quota::whereClientId(auth()->user()->client->id)
            )
            ->between(
                start: now()->startOfYear(),
                end:  now()->endOfYear(),
            )
            ->perDay()
            ->count();
        return [
            'chart' => [
                'type' => 'line',
                'height' => 350,
            ],
            'series' => [
                [
                    'name' => 'QuotaChart',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate)
                ],
            ],
            'xaxis' => [
                'categories' => $data->map(fn (TrendValue $value) => $value->date),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
