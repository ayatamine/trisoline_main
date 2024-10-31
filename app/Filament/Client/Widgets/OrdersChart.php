<?php

namespace App\Filament\Client\Widgets;

use Carbon\Carbon;
use App\Models\Order;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Forms\Components\DatePicker;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class OrdersChart extends ApexChartWidget
{
        /**
         * Chart Id
         *
         * @var string
         */
        protected static string $chartId = 'OrdersChart';
        protected static ?int $sort = 5;
        protected static ?string $maxHeight = '350px';

    
        /**
         * Widget Title
         *
         * @var string|null
         */
        protected static ?string $heading = 'OrdersChart';
        public function getColumnSpan(): int | string | array
        {
            return 1;
        }
        protected function getFormSchema(): array
        {
            return [
    
                DatePicker::make('date_start')
                    ->default( now()->startOfYear()),
        
                DatePicker::make('date_end')
                    ->default(now()->endOfYear())
        
            ];
        }
        /**
         * Chart options (series, labels, types, size, animations...)
         * https://apexcharts.com/docs/options
         *
         * @return array
         */
        protected function getOptions(): array
        {
            $dateStart = $this->filterFormData['date_start'];
            $dateEnd = $this->filterFormData['date_end'];
            
            $data = Trend::model(Order::class)
            ->query(  
                Order::query()
                ->whereClientId(auth()->user()->client->id)->status('completed')
            )
            ->between(
                start: Carbon::createFromDate($dateStart) ?? now()->startOfYear(),
                end: Carbon::createFromDate($dateEnd)?? now()->endOfYear(),
            )
            ->perMonth()
            ->count();
            $incompleted = Trend::model(Order::class)
            ->query(  
                Order::query()
                ->whereClientId(auth()->user()->client->id)->status('approved')
                ->orWhere('status','inspected')
            )
            ->between(
                start: Carbon::createFromDate($dateStart) ?? now()->startOfYear(),
                end: Carbon::createFromDate($dateEnd) ?? now()->endOfYear(),
            )
            ->perMonth()
            ->count();
            $pending = Trend::model(Order::class)
            ->query(  
                Order::query()
                ->whereClientId(auth()->user()->client->id)->status('pending')
            )
            ->between(
                start: Carbon::createFromDate($dateStart) ?? now()->startOfYear(),
                end: Carbon::createFromDate($dateEnd) ?? now()->endOfYear(),
            )
            ->perMonth()
            ->count();
            return [
                'chart' => [
                    'type' => 'area',
                    'height' => 350,
                ],
                'series' => [
                    [
                        'name' => 'Completed Orders',
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    ],
                    [
                        'name' => 'InCompleted Orders',
                        'data' => $incompleted->map(fn (TrendValue $value) => $value->aggregate),
                    ],
                    [
                        'name' => 'Pending Orders',
                        'data' => $pending->map(fn (TrendValue $value) => $value->aggregate),
                    ],
                ],
                'xaxis' => [
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    'labels' => [
                        'style' => [
                            'colors' => '#9ca3af',
                            'fontWeight' => 600,
                        ],
                    ],
                ],
                'yaxis' => [
                    'labels' => [
                        'style' => [
                            'colors' => '#9ca3af',
                            'fontWeight' => 600,
                        ],
                    ],
                ],
                'colors' => ['#E91E63','#6366f1','#2E93fA', '#66DA26', '#546E7A',  '#FF9800'],
    
                'stroke' => [
                    'curve' => 'smooth',
                ],
                'dataLabels' => [
                    'enabled' => false,
                ],
            ];
        
        }
    }
    
